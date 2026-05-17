<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Guest extends Model {
    protected $fillable = ['invitation_id','name','phone','address','pax','status'];
    public function invitation() { return $this->belongsTo(Invitation::class); }
}
