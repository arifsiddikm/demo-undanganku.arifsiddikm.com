<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Portfolio extends Model {
    protected $fillable = ['invitation_id','couple_name','photo','demo_url','package_name','rating','testimonial','is_visible'];
    protected $casts = ['is_visible'=>'boolean'];
}
