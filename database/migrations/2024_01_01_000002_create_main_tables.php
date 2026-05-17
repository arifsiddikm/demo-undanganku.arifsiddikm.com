<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =============================================
        // TEMPLATES
        // =============================================
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['basic', 'premium', 'luxury']);
            $table->string('thumbnail')->nullable();
            $table->string('preview_url')->nullable();
            $table->string('file_path')->nullable(); // path to template PHP file
            $table->text('description')->nullable();
            $table->string('primary_color', 20)->default('#F9A8D4');
            $table->string('secondary_color', 20)->default('#BFDBFE');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =============================================
        // PACKAGES
        // =============================================
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Premium, Luxury
            $table->string('slug')->unique();
            $table->integer('price');
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // list of features
            $table->integer('max_guests')->default(100);
            $table->boolean('has_music')->default(false);
            $table->boolean('has_gallery')->default(false);
            $table->boolean('has_livestream')->default(false);
            $table->boolean('has_rsvp')->default(true);
            $table->boolean('has_gift')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =============================================
        // BANK ACCOUNTS (no rekening)
        // =============================================
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number', 50);
            $table->string('account_name');
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // =============================================
        // ORDERS
        // =============================================
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // UNDANGANKU00000001
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('restrict');
            $table->integer('amount');
            $table->enum('payment_method', ['midtrans', 'bank_transfer'])->default('midtrans');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable(); // gopay, bca, etc
            $table->string('transfer_proof')->nullable(); // bukti transfer image
            $table->foreignId('bank_account_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // =============================================
        // INVITATIONS
        // =============================================
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('template_id')->constrained()->onDelete('restrict');
            $table->string('slug')->unique(); // undanganku.com/i/ikhwan-dan-akhwat
            $table->string('title'); // e.g. Ikhwan & Akhwat
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            // Groom
            $table->string('groom_name')->nullable();
            $table->string('groom_nickname')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('groom_photo')->nullable();
            $table->text('groom_bio')->nullable();
            $table->string('groom_instagram')->nullable();
            // Bride
            $table->string('bride_name')->nullable();
            $table->string('bride_nickname')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->string('bride_photo')->nullable();
            $table->text('bride_bio')->nullable();
            $table->string('bride_instagram')->nullable();
            // Event
            $table->string('akad_date')->nullable();
            $table->string('akad_time_start')->nullable();
            $table->string('akad_time_end')->nullable();
            $table->string('akad_venue')->nullable();
            $table->string('akad_address')->nullable();
            $table->string('akad_maps_url')->nullable();
            $table->string('resepsi_date')->nullable();
            $table->string('resepsi_time_start')->nullable();
            $table->string('resepsi_time_end')->nullable();
            $table->string('resepsi_venue')->nullable();
            $table->string('resepsi_address')->nullable();
            $table->string('resepsi_maps_url')->nullable();
            // Content
            $table->text('opening_text')->nullable();
            $table->text('closing_text')->nullable();
            $table->text('love_story')->nullable();
            $table->string('music_file')->nullable();
            $table->string('cover_photo')->nullable();
            // Custom colors
            $table->string('color_primary', 20)->nullable();
            $table->string('color_secondary', 20)->nullable();
            $table->boolean('music_autoplay')->default(true);
            $table->timestamps();
        });

        // =============================================
        // INVITATION PHOTOS (gallery)
        // =============================================
        Schema::create('invitation_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('photo');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =============================================
        // GUESTS
        // =============================================
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->integer('pax')->default(1); // jumlah tamu
            $table->enum('status', ['pending', 'hadir', 'tidak_hadir'])->default('pending');
            $table->timestamps();
        });

        // =============================================
        // RSVP (konfirmasi kehadiran tamu)
        // =============================================
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->foreignId('guest_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->integer('pax')->default(1);
            $table->enum('attendance', ['hadir', 'tidak_hadir'])->default('hadir');
            $table->text('message')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // =============================================
        // WISHES / UCAPAN
        // =============================================
        Schema::create('wishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('message');
            $table->boolean('is_visible')->default(true);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // =============================================
        // GIFT BANK ACCOUNTS (no rekening hadiah per undangan)
        // =============================================
        Schema::create('invitation_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_number', 50);
            $table->string('account_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // =============================================
        // PORTFOLIOS
        // =============================================
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('couple_name'); // e.g. Ikhwan & Akhwat
            $table->string('photo')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('package_name')->nullable();
            $table->integer('rating')->default(5);
            $table->text('testimonial')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // =============================================
        // TESTIMONIALS
        // =============================================
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('couple')->nullable();
            $table->string('photo')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =============================================
        // FAQS
        // =============================================
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('invitation_gifts');
        Schema::dropIfExists('wishes');
        Schema::dropIfExists('rsvps');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('invitation_photos');
        Schema::dropIfExists('invitations');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('templates');
    }
};
