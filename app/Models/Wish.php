<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Wish extends Model {
    protected $fillable = ['invitation_id','name','message','is_visible','ip_address'];
    protected $casts = ['is_visible'=>'boolean'];
    public function invitation() { return $this->belongsTo(Invitation::class); }
}
