<?php

namespace App\Services\Administration\Order;

use App\Models\Prescription\Prescription;
use App\Models\MedicineOrder\MedicineOrder;
use App\Models\OrderItem\OrderItem;
use App\Models\Pharmacy\Pharmacy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicineOrderService
{
    /**
     * Get all orders for current user
     */
    public function getUserOrders()
    {
        return MedicineOrder::with(['prescription', 'pharmacy', 'items'])
                           ->where('patient_id', Auth::id())
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
    }

    /**
     * Get order by ID with authorization check
     */
    public function getOrderById($orderId)
    {
        $order = MedicineOrder::with(['prescription.items', 'pharmacy', 'items', 'patient'])
                              ->findOrFail($orderId);

        // Check if order belongs to current user
        if ($order->patient_id !== Auth::id()) {
            throw new \Exception('Unauthorized access to order');
        }

        return $order;
    }

    /**
     * Create order from prescription
     */
    public function createOrderFromPrescription($prescriptionId, $pharmacyId, $paymentMethod, $deliveryAddress, $specialInstructions = null)
    {
        return DB::transaction(function () use ($prescriptionId, $pharmacyId, $paymentMethod, $deliveryAddress, $specialInstructions) {
            $prescription = Prescription::with(['items', 'patient'])->findOrFail($prescriptionId);

            // Check if prescription belongs to current user
            if ($prescription->patient_id !== Auth::id()) {
                throw new \Exception('Unauthorized access to prescription');
            }

            // Check if order already exists
            $existingOrder = MedicineOrder::where('prescription_id', $prescriptionId)
                                         ->where('patient_id', Auth::id())
                                         ->first();
            if ($existingOrder) {
                throw new \Exception('Order already exists for this prescription');
            }

            // Calculate total price
            $totalPrice = $this->calculateOrderTotal($prescription->items);

            $order = MedicineOrder::create([
                'prescription_id' => $prescriptionId,
                'patient_id' => Auth::id(),
                'pharmacy_id' => $pharmacyId,
                'status' => 'pending',
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'delivery_address' => $deliveryAddress,
                'special_instructions' => $specialInstructions,
                'ordered_at' => now()
            ]);

            // Create order items from prescription items
            foreach ($prescription->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_name' => $item->medicine_name,
                    'dosage' => $item->dosage,
                    'quantity' => $this->calculateQuantity($item),
                    'price' => $this->getMedicinePrice($item->medicine_name, $pharmacyId)
                ]);
            }

            return $order;
        });
    }

    /**
     * Cancel order
     */
    public function cancelOrder($orderId)
    {
        $order = MedicineOrder::findOrFail($orderId);

        // Check if order belongs to current user
        if ($order->patient_id !== Auth::id()) {
            throw new \Exception('Unauthorized access to order');
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            throw new \Exception('Only pending orders can be cancelled');
        }

        $order->update(['status' => 'cancelled']);

        return $order;
    }

    /**
     * Update order status (for pharmacy/admin use)
     */
    public function updateOrderStatus($orderId, $status)
    {
        $order = MedicineOrder::findOrFail($orderId);

        // Validate status transition
        $validStatuses = ['pending', 'processing', 'ready', 'out_for_delivery', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Invalid order status');
        }

        // Update status
        $order->update([
            'status' => $status,
            'updated_at' => now()
        ]);

        return $order;
    }

    /**
     * Get order statistics for dashboard
     */
    public function getOrderStatistics()
    {
        $userId = Auth::id();

        return [
            'total_orders' => MedicineOrder::where('patient_id', $userId)->count(),
            'pending_orders' => MedicineOrder::where('patient_id', $userId)->where('status', 'pending')->count(),
            'processing_orders' => MedicineOrder::where('patient_id', $userId)->where('status', 'processing')->count(),
            'delivered_orders' => MedicineOrder::where('patient_id', $userId)->where('status', 'delivered')->count(),
            'cancelled_orders' => MedicineOrder::where('patient_id', $userId)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Calculate total price for order
     */
    private function calculateOrderTotal($prescriptionItems)
    {
        $total = 0;
        foreach ($prescriptionItems as $item) {
            $quantity = $this->calculateQuantity($item);
            $price = $this->getMedicinePrice($item->medicine_name);
            $total += $quantity * $price;
        }
        return $total;
    }

    /**
     * Calculate quantity based on dosage and duration
     */
    private function calculateQuantity($prescriptionItem)
    {
        // Simple calculation - you might want to make this more sophisticated
        $dosagePerDay = (int) filter_var($prescriptionItem->dosage, FILTER_SANITIZE_NUMBER_INT) ?: 1;
        $durationDays = $this->parseDuration($prescriptionItem->duration);
        return $dosagePerDay * $durationDays;
    }

    /**
     * Parse duration string to days
     */
    private function parseDuration($duration)
    {
        // Simple parsing - you might want to make this more sophisticated
        if (preg_match('/(\d+)\s*days?/i', $duration, $matches)) {
            return (int) $matches[1];
        }
        return 7; // Default to 7 days
    }

    /**
     * Get medicine price (this would typically come from a pharmacy pricing table)
     */
    private function getMedicinePrice($medicineName, $pharmacyId = null)
    {
        // For now, return a default price - in a real system this would query pharmacy pricing
        return 10.00; // Default price per unit
    }

    /**
     * Get available pharmacies
     */
    public function getAvailablePharmacies()
    {
        return Pharmacy::whereHas('user', function ($query) {
            $query->where('status', true);
        })->get();
    }
}