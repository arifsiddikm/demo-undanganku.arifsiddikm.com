<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InvitationPhoto extends Model {
    protected $fillable = ['invitation_id','photo','caption','sort_order'];
    public function invitation() { return $this->belongsTo(Invitation::class); }
}
