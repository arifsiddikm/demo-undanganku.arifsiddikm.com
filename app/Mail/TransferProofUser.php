<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferProofUser extends Mailable {
    use Queueable, SerializesModels;
    public Order $order;
    public function __construct(Order $order) { $this->order = $order; }
    public function build() {
        return $this->subject('⏳ Bukti Transfer Diterima - UndanganKu')
                    ->view('emails.transfer-proof-user')
                    ->with(['order' => $this->order]);
    }
}
