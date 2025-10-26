<?php

namespace App\Http\Controllers\Administration\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Prescription\Prescription;
use App\Models\MedicineOrder\MedicineOrder;
use App\Services\Administration\Order\MedicineOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class MedicineOrderController extends Controller
{
    protected $medicineOrderService;

    public function __construct(MedicineOrderService $medicineOrderService)
    {
        $this->medicineOrderService = $medicineOrderService;
    }

    /**
     * Display pharmacy orders
     */
    public function index()
    {
        
    }

    public function myorder(){
        $orders = $this->medicineOrderService->getUserOrders();
        return view('admin.orders.patient.index', compact('orders'));
    }

    public function pharmacyAllUserOrder(){
        $orders = $this->medicineOrderService->getPharmacyOrders();
        return view('admin.orders.pharmacy.index', compact('orders'));
    }
    /**
     * Show pharmacy selection page for medicine order
     */
    public function selectPharmacy($prescriptionId)
    {
        $prescription = Prescription::with(['items', 'patient', 'doctor.user'])->findOrFail($prescriptionId);

        // Check if prescription belongs to current user (patient)
        if ($prescription->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized access to prescription');
        }

        // Check if order already exists for this prescription
        $existingOrder = MedicineOrder::where('prescription_id', $prescriptionId)
                                     ->where('patient_id', Auth::id())
                                     ->first();
        if ($existingOrder) {
            return redirect()->route('administration.orders.show', $existingOrder->id);
        }

        $pharmacies = $this->medicineOrderService->getAvailablePharmacies();

        return view('admin.orders.pharmacy.select', compact('prescription', 'pharmacies'));
    }

    /**
     * Create medicine order from prescription
     */
    public function createOrder(OrderStoreRequest $request, $prescriptionId)
    {
        try {
            $order = $this->medicineOrderService->createOrderFromPrescription(
                $prescriptionId,
                $request->pharmacy_id,
                $request->payment_method,
                $request->delivery_address,
                $request->special_instructions
            );

            return redirect()->route('administration.orders.confirmation', $order->id)
                           ->with('success', 'Medicine order created successfully!');

        } catch (Exception $e) {
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Show order confirmation page
     */
    public function showConfirmation($orderId)
    {
        $order = MedicineOrder::with(['items', 'prescription', 'pharmacy', 'patient'])
                              ->findOrFail($orderId);

        // Check if order belongs to current user
        if ($order->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order');
        }

        return view('admin.orders.confirmation', compact('order'));
    }

    /**
     * Show order details
     */
    public function show($orderId)
    {
        try {
            $order = $this->medicineOrderService->getOrderById($orderId);
            return view('admin.orders.show', compact('order'));
        } catch (Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    /**
     * Show order details for pharmacy
     */
    public function showForPharmacy($orderId)
    {
        try {
            $order = $this->medicineOrderService->getOrderByIdForPharmacy($orderId);
            return view('admin.orders.pharmacy.show', compact('order'));
        } catch (Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    /**
     * Cancel order
     */
    public function cancel($orderId)
    {
        try {
            $this->medicineOrderService->cancelOrder($orderId);
            return back()->with('success', 'Order cancelled successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    /**
     * Update order status (for pharmacy/admin use)
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,out_for_delivery,delivered,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            $order = $this->medicineOrderService->updateOrderStatus($orderId, $request->status);

            $message = 'Order status updated to ' . ucfirst($request->status) . ' successfully';

            if ($request->notes) {
                // You could save notes to an order_updates table here
                $message .= '. Note: ' . $request->notes;
            }
            $notofication = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return back()->with($notofication);
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
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
}
