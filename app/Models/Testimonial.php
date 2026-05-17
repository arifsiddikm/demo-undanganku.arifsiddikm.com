<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model {
    protected $fillable = ['name','couple','photo','content','rating','is_visible','sort_order'];
    protected $casts = ['is_visible'=>'boolean'];
}
