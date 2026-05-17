<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $fillable = ['order_number','user_id','package_id','amount','payment_method','payment_status','snap_token','transaction_id','payment_type','transfer_proof','bank_account_id','paid_at','notes'];
    protected $casts = ['paid_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function package() { return $this->belongsTo(Package::class); }
    public function bankAccount() { return $this->belongsTo(BankAccount::class); }
    public function invitation() { return $this->hasOne(Invitation::class); }
}
