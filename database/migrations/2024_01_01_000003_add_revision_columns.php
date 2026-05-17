<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns to invitations
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('font_family')->default('Cormorant Garamond')->after('color_secondary');
            $table->text('invitation_message')->nullable()->after('font_family'); // custom WA message
            $table->json('love_story_items')->nullable()->after('love_story'); // multi-section love story
            $table->boolean('resepsi_same_as_akad')->default(false)->after('resepsi_maps_url');
            $table->string('selected_music_key')->nullable()->after('music_file'); // from preset list
            $table->string('livestream_url')->nullable()->after('music_autoplay');
            $table->string('couple_order', 15)->default('bride_first')->after('livestream_url'); // 'bride' or 'groom'
        });

        // Add user_testimonials table
        Schema::create('user_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->boolean('allow_portfolio')->default(false); // user consent
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Add preset_musics table - managed by admin
        Schema::create('preset_musics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('file_url'); // URL or storage path
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Add slug_history to track used slugs
        Schema::table('invitations', function (Blueprint $table) {
            // already has slug unique constraint - fine
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preset_musics');
        Schema::dropIfExists('user_testimonials');
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['font_family','invitation_message','love_story_items','resepsi_same_as_akad','selected_music_key','livestream_url','couple_order']);
        });
    }
};
