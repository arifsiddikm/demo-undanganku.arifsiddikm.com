<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedAdmin extends Mailable {
    use Queueable, SerializesModels;
    public Order $order;
    public function __construct(Order $order) { $this->order = $order; }
    public function build() {
        return $this->subject('🔔 Pesanan Baru #' . $this->order->order_number . ' - UndanganKu')
                    ->view('emails.order-created-admin')
                    ->with(['order' => $this->order]);
    }
}
