<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model {
    protected $fillable = [
        'user_id','order_id','template_id','slug','title','status',
        // Groom
        'groom_name','groom_nickname','groom_father','groom_mother',
        'groom_photo','groom_bio','groom_instagram',
        // Bride
        'bride_name','bride_nickname','bride_father','bride_mother',
        'bride_photo','bride_bio','bride_instagram',
        // Event
        'akad_date','akad_time_start','akad_time_end',
        'akad_venue','akad_address','akad_maps_url',
        'resepsi_date','resepsi_time_start','resepsi_time_end',
        'resepsi_venue','resepsi_address','resepsi_maps_url',
        'resepsi_same_as_akad',
        // Content
        'opening_text','closing_text',
        'love_story','love_story_items',
        'cover_photo',
        // Music
        'music_file','selected_music_key','music_autoplay',
        'livestream_url',
        // Appearance
        'color_primary','color_secondary','font_family',
        'couple_order',
        // WA Message
        'invitation_message',
    ];

    protected $casts = [
        'music_autoplay'     => 'boolean',
        'resepsi_same_as_akad' => 'boolean',
        'love_story_items'   => 'array',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function template() { return $this->belongsTo(Template::class); }
    public function order()    { return $this->belongsTo(Order::class); }
    public function photos()   { return $this->hasMany(InvitationPhoto::class)->orderBy('sort_order'); }
    public function guests()   { return $this->hasMany(Guest::class); }
    public function rsvps()    { return $this->hasMany(Rsvp::class); }
    public function wishes()   { return $this->hasMany(Wish::class); }
    public function gifts()    { return $this->hasMany(InvitationGift::class); }
}
