<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PresetMusic extends Model {
    protected $table = 'preset_musics';
    protected $fillable = ['title','artist','file_url','is_active','sort_order'];
    protected $casts = ['is_active'=>'boolean'];
}
