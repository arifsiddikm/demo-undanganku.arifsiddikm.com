<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UserTestimonial extends Model {
    protected $fillable = ['order_id','user_id','content','rating','allow_portfolio','status'];
    protected $casts = ['allow_portfolio'=>'boolean'];
    public function order() { return $this->belongsTo(Order::class); }
    public function user() { return $this->belongsTo(User::class); }
}
