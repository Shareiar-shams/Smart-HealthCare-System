<?php

namespace App\Notifications;

use App\Models\Appointment\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Appointment $appointment, public bool $statusUpdate = false)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
         return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appointment = $this->appointment;
        if ($this->statusUpdate) {
            return (new MailMessage)
                ->subject('Appointment Status Updated')
                ->line("Your appointment on {$appointment->appointment_date} at {$appointment->appointment_time} is now '{$appointment->status}'.");
        }

        return (new MailMessage)
            ->subject('New Appointment Booked')
            ->line("A new appointment has been booked by {$appointment->patient->name}.")
            ->line("Date: {$appointment->appointment_date}")
            ->line("Time: {$appointment->appointment_time}")
            ->action('View Appointments', url('/appointments'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'doctor_id' => $this->appointment->doctor_id,
            'patient_id' => $this->appointment->patient_id,
            'status' => $this->appointment->status,
            'appointment_date' => $this->appointment->appointment_date,
            'appointment_time' => $this->appointment->appointment_time,
        ];
    }
}
