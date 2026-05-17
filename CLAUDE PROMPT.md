# CLAUDE PROMPT — UndanganKu (PRD Lengkap)

> Upload file ini ke Claude dan ketik: **"Bantu saya build project ini dari awal"**

---

## Identitas Proyek

**Nama:** UndanganKu  
**Tagline:** Buat undangan pernikahan digital yang elegan dalam hitungan menit  
**Tipe:** SaaS Web App — Digital Wedding Invitation Maker  
**Tech Stack:** Laravel 13 · PHP 8.3 · MySQL · Blade · Tailwind CSS (CDN) · SweetAlert2 · Flatpickr · CKEditor 5 · Midtrans (via Riplabs Snap) · SMTP Mail

---

## Deskripsi Singkat

UndanganKu adalah platform SaaS untuk membuat undangan pernikahan digital. User mendaftar, memilih template, mengisi data pasangan dan acara lewat editor visual, lalu membagikan link undangan ke tamu. Tamu bisa membuka undangan, mengisi RSVP, dan mengirim ucapan. Sistem memiliki 3 tier paket berbayar dengan fitur yang berbeda, pembayaran via Midtrans atau transfer manual.

---

## Role & Akses

| Role | Akses |
|---|---|
| `guest` | Landing page, preview template, halaman undangan publik |
| `user` | Dashboard, editor undangan, order, profil |
| `admin` | Panel `/webmin` — semua manajemen |

---

## Database Schema

### Tabel Utama

```
users
  id, name, email, password, role (user/admin), phone, photo, is_active,
  remember_token, email_verified_at, timestamps

templates
  id, name, slug, thumbnail, preview_url, file_path, category,
  color_primary, color_secondary, is_active, timestamps

packages
  id, name, slug (basic/premium/luxury), description, price,
  features (JSON), max_guests,
  has_music, has_gallery, has_livestream, has_rsvp, has_gift (boolean),
  is_active, sort_order, timestamps

bank_accounts
  id, bank_name, account_number, account_name, logo, is_active, timestamps

orders
  id, user_id, invitation_id, package_id, bank_account_id,
  order_number, amount, payment_method (midtrans/bank_transfer),
  payment_status (pending/paid/failed/expired),
  snap_token, transfer_proof, notes,
  paid_at, confirmed_at, timestamps

invitations
  id, user_id, order_id, template_id, slug, title, status (draft/active/inactive),
  -- Groom
  groom_name, groom_nickname, groom_father, groom_mother,
  groom_photo, groom_bio, groom_instagram,
  -- Bride
  bride_name, bride_nickname, bride_father, bride_mother,
  bride_photo, bride_bio, bride_instagram,
  -- Event Akad
  akad_date, akad_time_start, akad_time_end,
  akad_venue, akad_address, akad_maps_url,
  -- Event Resepsi
  resepsi_date, resepsi_time_start, resepsi_time_end,
  resepsi_venue, resepsi_address, resepsi_maps_url,
  resepsi_same_as_akad (boolean),
  -- Content
  opening_text, closing_text,
  love_story_items (JSON array: [{title, date, content}]),
  cover_photo, couple_order (bride_first/groom_first),
  -- Music
  music_file, selected_music_key, music_autoplay (boolean),
  livestream_url,
  -- Appearance
  color_primary, color_secondary, font_family,
  -- WA
  invitation_message, timestamps

invitation_photos
  id, invitation_id, photo, sort_order, timestamps

guests
  id, invitation_id, name, phone, pax, status (pending/hadir/tidak_hadir), timestamps

rsvps
  id, invitation_id, guest_id, name, phone, pax, status, message, timestamps

wishes
  id, invitation_id, name, message, ip_address, timestamps

invitation_gifts
  id, invitation_id, bank_name, account_number, account_name, timestamps

preset_musics
  id, title, artist, file_url, duration, is_active, sort_order, timestamps

portfolios
  id, couple_name, photo, package_name, rating, testimonial,
  demo_url, is_visible, timestamps

testimonials
  id, user_id, order_id, rating, content, is_approved, timestamps

faqs
  id, question, answer, sort_order, is_active, timestamps

password_reset_tokens
  email, token, created_at
```

---

## Struktur Halaman & Routes

### Public (guest)
```
GET  /                          → landing page
GET  /preset                    → daftar template
GET  /preset/{slug}/preview     → preview template (dummy data)
GET  /portfolio                 → portfolio undangan
GET  /{slug}                    → halaman undangan aktif
GET  /{slug}?untuk={name}       → undangan personal per tamu
POST /{slug}/rsvp               → submit RSVP
POST /{slug}/wish               → submit ucapan
```

### Auth
```
GET/POST  /login
GET/POST  /register
POST      /logout
GET       /forgot-password
POST      /forgot-password      → kirim email reset
GET       /reset-password/{token}
POST      /reset-password       → proses reset + auto-login
```

### Dashboard (auth)
```
GET   /dashboard
GET   /dashboard/invitations
POST  /dashboard/invitations/create
GET   /dashboard/invitations/{id}/editor
POST  /dashboard/invitations/{id}/save         → AJAX JSON save
POST  /dashboard/invitations/{id}/cover        → upload cover photo
POST  /dashboard/invitations/{id}/groom-photo
POST  /dashboard/invitations/{id}/bride-photo
POST  /dashboard/invitations/{id}/gallery
DELETE /dashboard/invitations/{id}/gallery/{photoId}
POST  /dashboard/invitations/{id}/music        → upload musik custom
DELETE /dashboard/invitations/{id}
GET   /dashboard/orders
GET   /dashboard/orders/{id}
POST  /dashboard/orders/{id}/upload-proof
GET   /checkout/{package_slug}/{invitationId?}
POST  /orders/store
GET   /payment/finish
POST  /payment/callback
GET   /dashboard/profile
POST  /dashboard/profile
GET   /check-slug?slug=xxx      → cek ketersediaan slug (AJAX)
```

### Admin (/webmin)
```
GET   /webmin/dashboard
GET   /webmin/users
POST  /webmin/users/{id}/toggle
GET   /webmin/orders
POST  /webmin/orders/{id}/confirm
GET   /webmin/invitations
GET   /webmin/invitations/{id}
GET   /webmin/templates
GET/POST /webmin/templates/create
GET/POST /webmin/templates/{id}/edit
DELETE /webmin/templates/{id}
GET/POST /webmin/bank-accounts   (CRUD)
GET   /webmin/music
POST  /webmin/music/store
POST  /webmin/music/upload
DELETE /webmin/music/{id}
GET   /webmin/portfolios         (CRUD)
GET   /webmin/testimonials       (CRUD)
GET   /webmin/faqs               (CRUD)
```

---

## Fitur Detail

### Landing Page
- Hero section dengan animasi phone mockup & stats counter (undangan dibuat, template, user)
- Section: Cara Kerja (3 langkah), Pilihan Paket (3 tier), Preview Template, Portfolio, Testimoni, FAQ
- Navbar sticky dengan tombol login/register
- Footer dengan link sosial & kontak WA admin
- FAB (Floating Action Button) WhatsApp admin

### Editor Undangan (3-panel layout)
- **Kiri:** Sidebar navigasi 13 section
- **Tengah:** Form edit konten per section
- **Kanan:** Preview iframe live (toggle Desktop/Mobile)

**Section editor:**
1. Ringkasan (slug kustom + cek availability AJAX, status undangan)
2. Sampul (template selector, couple_order toggle, color picker, font selector)
3. Kata Pembuka (rich text CKEditor + template referensi)
4. Profil Pria (nama, nick, ayah, ibu, instagram, foto, bio)
5. Profil Wanita (sama seperti pria)
6. Detail Acara (akad + resepsi + toggle resepsi=akad + livestream URL)
7. Galeri (upload multi foto, langsung muncul di list)
8. Love Story (tambah/edit/hapus item: title, date, content — simpan sebagai JSON array)
9. Kata Penutup (rich text CKEditor)
10. Daftar Tamu (tambah/hapus tamu, link personal per tamu)
11. Konfirmasi Hadir / RSVP (list RSVP realtime)
12. Ucapan & Doa (list ucapan)
13. No. Rekening (tambah/hapus rekening hadiah)
14. Musik (pilih dari preset admin / upload sendiri + toggle autoplay)
15. Teks Undangan WA (textarea custom message)
16. Pengaturan (slug, status)

**Save mechanism:**
- Auto-save debounce 1500ms untuk perubahan biasa
- Direct fetch untuk: `template_id`, `couple_order`, `selected_music_key`, `invitation_message`, love_story items
- `collectFormData()` ambil semua input/select/textarea + radio:checked + checkbox

### Template Undangan
6 template tersedia, masing-masing file Blade terpisah:
- `sakura-bloom` — pink sakura, elegan
- `blossom-ivory` — ivory, minimalis
- `crimson-petal` — merah marun, mewah
- `golden-garden` — emas, taman
- `midnight-sage` — hijau gelap, modern
- `royal-blue` — biru navy, formal

Setiap template mendukung:
- Slide "Buka Undangan" (opening screen, hidden saat preview mode)
- Couple order (`bride_first` default / `groom_first`)
- Section: hero, profil pasangan, detail acara, galeri, love story, RSVP, ucapan, gift, musik autoplay
- Variabel dari Blade: `$invitation`, `$guestName`, `$isPreview`, `$coupleOrder`
- `love_story_items` di-handle: `is_array($invitation->love_story_items) ? $invitation->love_story_items : json_decode(...)`

### Sistem Paket & Pembayaran
```
Basic   → RSVP, ucapan, tamu unlimited
Premium → + galeri foto, musik latar, love story
Luxury  → + livestream, semua fitur
```
- Checkout via **Midtrans Snap** (QRIS, GoPay, transfer bank, kartu kredit)
- Checkout via **Transfer Manual** (upload bukti transfer, konfirmasi admin)
- Callback Midtrans dengan validasi `X-Callback-Key`
- Auto-aktivasi undangan setelah pembayaran sukses
- Email notifikasi: order created (admin), paid (admin), confirmed (user), transfer proof (admin+user)

### Forgot/Reset Password
- Form input email → generate token 64 char (hash di DB, expiry 60 menit)
- Email terkirim **synchronous** (bukan queue) dengan `Mail::mailer(config('mail.default'))->to()->send()`
- Link reset: `/reset-password/{token}?email={email}`
- Setelah reset password berhasil → **auto-login langsung** → redirect dashboard

---

## Model & Relasi Penting

```php
// User
hasMany: Invitation, Order

// Invitation
belongsTo: User, Template, Order
hasMany: InvitationPhoto, Guest, Rsvp, Wish, InvitationGift
$fillable: [semua kolom termasuk love_story_items, invitation_message,
            selected_music_key, couple_order, livestream_url, font_family]
$casts: ['love_story_items' => 'array', 'music_autoplay' => 'boolean',
         'resepsi_same_as_akad' => 'boolean']

// Order
belongsTo: User, Invitation, Package, BankAccount
```

---

## Controller Penting

### `InvitationController@save`
```php
// Menerima JSON body dari AJAX editor
// Allowed fields di-whitelist
// love_story_items: decode dari JSON string ke array sebelum update()
// set_time_limit(120) untuk cegah timeout
$invitation->update($data);
return response()->json(['success' => true]);
```

### `PaymentController@getSnapToken`
```php
// POST /payment/get-snap-token
// Create order → hit Riplabs API → return snap_token
```

### `PaymentController@callback`
```php
// Validasi X-Callback-Key
// Update order status
// Aktivasi undangan jika paid
```

---

## Email System (Mailable — sync, bukan queue)

| Mailable | Trigger | Penerima |
|---|---|---|
| `OrderCreatedAdmin` | Order baru dibuat | Admin |
| `OrderPaidAdmin` | Midtrans callback paid | Admin |
| `OrderConfirmedUser` | Admin konfirmasi manual | User |
| `TransferProofAdmin` | User upload bukti | Admin |
| `TransferProofUser` | User upload bukti | User |
| `ResetPasswordMail` | Forgot password | User |

> **Penting:** Semua Mailable TIDAK menggunakan `ShouldQueue` interface agar terkirim synchronous.

---

## Styling & UI

- CSS custom properties: `--color-pink`, `--color-muted`, `--font-display`, `--font-body`
- Class utility: `btn-primary`, `btn-outline`, `btn-danger`, `form-input`, `form-label`, `form-group`, `form-textarea`, `dash-card`, `alert`, `badge`
- Responsive: grid 2-kolom untuk auth pages (kiri: ilustrasi, kanan: form)
- Placeholder nama: **Pengantin Pria / Ikhwan** dan **Pengantin Wanita / Akhwat** (bukan nama spesifik)
- Password field: semua form wajib `minlength="8"`
- Favicon: `favicon.svg` (pink #F472B6 dengan ikon cincin)

---

## Hal-hal Kritis yang Wajib Diperhatikan

1. **`$fillable` model `Invitation`** harus include SEMUA kolom, termasuk yang ditambah di migration revision. Jika tidak, Laravel silent-drop data saat `update()`.

2. **`love_story_items`** di-cast sebagai `'array'` di model. Template Blade harus handle dua kemungkinan: array (dari cast) atau string (data lama). Gunakan:
   ```php
   $stories = is_array($invitation->love_story_items)
       ? $invitation->love_story_items
       : (json_decode($invitation->love_story_items, true) ?? []);
   ```

3. **Musik preset save** — gunakan direct fetch dengan payload `{ selected_music_key: url }`, bukan lewat `collectFormData()`.

4. **Template ganti** — gunakan direct fetch dengan payload `{ template_id: id }`, bukan debounced auto-save.

5. **couple_order** — satu hidden input `#coupleOrderInput` saja sebagai sumber kebenaran. Direct fetch `{ couple_order: order }` saat toggle.

6. **Email reset password** — gunakan `Mail::mailer(config('mail.default'))->to()->send()` bukan `Mail::to()->send()` agar tidak masuk queue.

7. **`QUEUE_CONNECTION=database`** — jika aktif, semua mail biasa bisa masuk queue. Pastikan Mailable tidak implement `ShouldQueue`.

8. **Timeout 30s** — tambahkan `set_time_limit(120)` di method `save()` controller.

9. **`collectFormData()`** — harus include `input[type=radio]:checked` untuk menangkap `template_id`.

10. **`couple_order` duplikat** — jangan ada dua widget (toggle + radio) dengan `name="couple_order"` dalam satu halaman editor.

---

## Environment Variables (tanpa value rahasia)

```env
APP_NAME=UndanganKu
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=undanganku
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="UndanganKu"

ADMIN_EMAIL=
ADMIN_WHATSAPP=

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SNAP_JS_URL=https://app.sandbox.midtrans.com/snap/snap.js
RIPLABS_API_URL=
RIPLABS_API_KEY=
```

> **Note:** Set `QUEUE_CONNECTION=sync` untuk development agar email langsung terkirim tanpa perlu `php artisan queue:work`.
