<?php
// ============================================================
// Run: php artisan make:model --no (these are the model files)
// Place each class in its own file under app/Models/
// ============================================================

// app/Models/Template.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Template extends Model {
    protected $fillable = ['name','slug','category','thumbnail','preview_url','file_path','description','primary_color','secondary_color','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function invitations() { return $this->hasMany(Invitation::class); }
}
