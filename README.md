# UndanganKu — Digital Wedding Invitation Maker

Website SaaS undangan pernikahan digital berbasis Laravel. User bisa pilih template, edit konten via editor visual, dan bagikan undangan lewat link personal.

🌐 **Live Demo:** [demo-undanganku.arifsiddikm.com](https://demo-undanganku.arifsiddikm.com)

---

## Tech Stack

- **Backend:** PHP 8.3 + Laravel 13
- **Database:** MySQL
- **Frontend:** Blade · Tailwind CSS · Alpine.js · SweetAlert2 · Flatpickr
- **Rich Text Editor:** CKEditor 5
- **Payment:** Midtrans (via Riplabs Snap)
- **Email:** SMTP (Hostinger)
- **Storage:** Laravel Storage (public disk)

---

## Fitur

**Frontend Publik**
- Landing page dengan preview template & pricing
- Halaman portfolio undangan & testimoni
- FAQ

**Dashboard User**
- Editor undangan 3-panel (form · preview desktop/mobile)
- 6 template undangan siap pakai
- Upload foto sampul, pengantin, galeri
- Manajemen tamu + personalisasi link per tamu
- RSVP & ucapan doa publik
- Input no. rekening hadiah
- Pilih / upload musik latar
- Love story timeline
- Teks undangan WA custom
- Upgrade paket (Basic / Premium / Luxury)
- Checkout via Midtrans atau transfer manual

**Admin Panel** (`/webmin`)
- Manajemen user, order, undangan
- CRUD template, paket, bank account
- Upload preset musik
- Kelola portfolio & testimoni
- CRUD FAQ

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/arifsiddikm/undanganku.git
cd undanganku

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Konfigurasi environment
cp file env to .env and setting your password
php artisan key:generate

# 4. Setup database
php artisan migrate
php artisan db:seed

# 5. Storage link
php artisan storage:link

# 6. Jalankan server
php artisan serve
```

Akses di `http://localhost:8000`

---

## Login Demo

```
# User
URL   : http://localhost:8000/login
Email : reza@demo.com
Pass  : user123

# Admin
URL   : http://localhost:8000/webmin
Email : admin@undanganku.com
Pass  : admin123
```

---

## Konfigurasi `.env` Penting

```env
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=undanganku
DB_USERNAME=root
DB_PASSWORD=

# Mail (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="UndanganKu"

# Midtrans
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SNAP_JS_URL=https://app.sandbox.midtrans.com/snap/snap.js

# Admin info
ADMIN_EMAIL=
ADMIN_WHATSAPP=
```

---

## Struktur Paket

| Paket | Fitur |
|---|---|
| Basic | RSVP, ucapan, tamu unlimited |
| Premium | + Galeri foto, musik latar |
| Luxury | + Livestream, semua fitur |

---

### Support me on

<a href="https://saweria.co/arifsiddikm" target="_blank"><img src="https://user-images.githubusercontent.com/26188697/180601310-e82c63e4-412b-4c36-b7b5-7ba713c80380.png" alt="Sawer me" height="41" width="174"></a>
