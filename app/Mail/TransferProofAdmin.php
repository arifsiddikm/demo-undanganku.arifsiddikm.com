<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferProofAdmin extends Mailable {
    use Queueable, SerializesModels;
    public Order $order;
    public ?string $proofUrl;
    public function __construct(Order $order, ?string $proofUrl = null) {
        $this->order = $order;
        $this->proofUrl = $proofUrl;
    }
    public function build() {
        return $this->subject('💳 Bukti Transfer Baru #' . $this->order->order_number . ' - UndanganKu')
                    ->view('emails.transfer-proof-admin')
                    ->with(['order' => $this->order, 'proofUrl' => $this->proofUrl]);
    }
}
