<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Package extends Model {
    protected $fillable = ['name','slug','price','description','features','max_guests','has_music','has_gallery','has_livestream','has_rsvp','has_gift','is_active','sort_order'];
    protected $casts = ['features'=>'array','has_music'=>'boolean','has_gallery'=>'boolean','has_livestream'=>'boolean','has_rsvp'=>'boolean','has_gift'=>'boolean','is_active'=>'boolean'];
    public function orders() { return $this->hasMany(Order::class); }
}
