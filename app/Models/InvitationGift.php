<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InvitationGift extends Model {
    protected $fillable = ['invitation_id','bank_name','account_number','account_name','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function invitation() { return $this->belongsTo(Invitation::class); }
}
