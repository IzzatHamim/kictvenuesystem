<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Cancelled - ' . $this->booking->venue->name)
            ->line('Your booking has been cancelled by the administrator.')
            ->line('**Venue:** ' . $this->booking->venue->name)
            ->line('**Date:** ' . $this->booking->booking_date)
            ->line('**Time:** ' . $this->booking->start_time . ' - ' . $this->booking->end_time)
            ->line('**Reason:** ' . $this->booking->cancellation_reason)
            ->line('If you have any questions, please contact us.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'venue_name' => $this->booking->venue->name,
            'booking_date' => $this->booking->booking_date,
            'reason' => $this->booking->cancellation_reason,
        ];
    }
}