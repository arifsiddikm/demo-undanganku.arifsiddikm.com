<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Rsvp extends Model {
    protected $fillable = ['invitation_id','guest_id','name','phone','pax','attendance','message','ip_address'];
    public function invitation() { return $this->belongsTo(Invitation::class); }
    public function guest() { return $this->belongsTo(Guest::class); }
}
