<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── USERS ──────────────────────────────────────────────────
        DB::table('users')->insert([
            ['name'=>'Admin UndanganKu','email'=>'admin@undanganku.com','password'=>Hash::make('admin123'),'role'=>'admin','phone'=>'6289514392694','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Reza Pratama','email'=>'reza@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6281234567890','is_active'=>true,'created_at'=>now()->subDays(30),'updated_at'=>now()],
            ['name'=>'Vina Aulia','email'=>'vina@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6281298765432','is_active'=>true,'created_at'=>now()->subDays(20),'updated_at'=>now()],
            ['name'=>'Bagas Setiawan','email'=>'bagas@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6285611223344','is_active'=>true,'created_at'=>now()->subDays(15),'updated_at'=>now()],
            ['name'=>'Nurul Hidayah','email'=>'nurul@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6281355667788','is_active'=>true,'created_at'=>now()->subDays(10),'updated_at'=>now()],
            ['name'=>'Dimas Ardiansyah','email'=>'dimas@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6289912345678','is_active'=>true,'created_at'=>now()->subDays(5),'updated_at'=>now()],
        ]);

        // More demo users for testing
        DB::table('users')->insert([
            ['name'=>'Sari Wulandari','email'=>'sari@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6281277889900','is_active'=>true,'created_at'=>now()->subDays(7),'updated_at'=>now()],
            ['name'=>'Eko Prasetyo','email'=>'eko@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6285233445566','is_active'=>true,'created_at'=>now()->subDays(2),'updated_at'=>now()],
            ['name'=>'Liana Putri','email'=>'liana@demo.com','password'=>Hash::make('user123'),'role'=>'user','phone'=>'6281388990011','is_active'=>true,'created_at'=>now()->subDays(1),'updated_at'=>now()],
        ]);

        // ── PACKAGES ───────────────────────────────────────────────
        // Only columns that exist: name,slug,price,description,features,max_guests,
        //   has_music,has_gallery,has_livestream,has_rsvp,has_gift,is_active,sort_order
        DB::table('packages')->insert([
            [
                'name'=>'Basic','slug'=>'basic','price'=>75000,'sort_order'=>1,'is_active'=>true,
                'description'=>'Template basic elegan untuk pernikahan sederhana namun berkesan.',
                'features'=>json_encode(['2 Template Basic pilihan','RSVP & Ucapan tamu','Galeri 5 foto','Countdown timer','Share link personal','No. rekening hadiah','Dukungan WhatsApp']),
                'max_guests'=>100,'has_music'=>false,'has_gallery'=>false,
                'has_rsvp'=>true,'has_gift'=>true,'has_livestream'=>false,
                'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Premium','slug'=>'premium','price'=>150000,'sort_order'=>2,'is_active'=>true,
                'description'=>'Semua template premium, musik latar romantis, galeri foto tak terbatas.',
                'features'=>json_encode(['Semua template Basic & Premium','Musik latar romantis','Galeri tak terbatas','RSVP & manajemen tamu','Love Story timeline','Live streaming link','Prioritas dukungan']),
                'max_guests'=>500,'has_music'=>true,'has_gallery'=>true,
                'has_rsvp'=>true,'has_gift'=>true,'has_livestream'=>true,
                'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Luxury','slug'=>'luxury','price'=>299000,'sort_order'=>3,'is_active'=>true,
                'description'=>'Pengalaman undangan digital paling mewah dengan semua fitur eksklusif.',
                'features'=>json_encode(['Semua template termasuk Luxury','Musik latar & upload custom','Galeri & video tak terbatas','Manajemen tamu VIP','Love Story & countdown mewah','Admin dedicated support','QR Code undangan pribadi']),
                'max_guests'=>0,'has_music'=>true,'has_gallery'=>true,
                'has_rsvp'=>true,'has_gift'=>true,'has_livestream'=>true,
                'created_at'=>now(),'updated_at'=>now(),
            ],
        ]);

        // ── TEMPLATES ──────────────────────────────────────────────
        // Columns: name,slug,category,file_path,description,primary_color,secondary_color,thumbnail,preview_url,is_active,sort_order
        DB::table('templates')->insert([
            ['name'=>'Sakura Bloom','slug'=>'sakura-bloom','category'=>'basic','file_path'=>'sakura-bloom','description'=>'Ivory & rose hangat. Foto arch rounded, tipografi Fraunces italic, timeless dan elegan.','primary_color'=>'#C1826A','secondary_color'=>'#EFE5D8','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Blossom Ivory','slug'=>'blossom-ivory','category'=>'basic','file_path'=>'blossom-ivory','description'=>'Krem & coklat lembut, Lora serif. Clean dan hangat untuk semua jenis pernikahan.','primary_color'=>'#8B6F5E','secondary_color'=>'#F2EAE1','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Royal Blue','slug'=>'royal-blue','category'=>'premium','file_path'=>'royal-blue','description'=>'Dark hitam & gold, DM Serif Display. Editorial modern dan sophisticated.','primary_color'=>'#BFA16A','secondary_color'=>'#0E0E0E','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Midnight Sage','slug'=>'midnight-sage','category'=>'premium','file_path'=>'midnight-sage','description'=>'Dark green sage editorial. Kontras kuat, natural, dan berkesan.','primary_color'=>'#4A7C59','secondary_color'=>'#2C3E2D','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Golden Garden','slug'=>'golden-garden','category'=>'luxury','file_path'=>'golden-garden','description'=>'Deep brown & amber, Gloock italic. Watermark ghost, ornamen berlian mewah.','primary_color'=>'#C49A3C','secondary_color'=>'#2C1A0A','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>5,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Crimson Petal','slug'=>'crimson-petal','category'=>'luxury','file_path'=>'crimson-petal','description'=>'Deep burgundy & rose gold. Cormorant italic dramatis untuk pernikahan mewah.','primary_color'=>'#B5496A','secondary_color'=>'#C8956A','thumbnail'=>null,'preview_url'=>null,'is_active'=>true,'sort_order'=>6,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── BANK ACCOUNTS ──────────────────────────────────────────
        DB::table('bank_accounts')->insert([
            ['bank_name'=>'BCA','account_number'=>'1234567890','account_name'=>'PT UndanganKu Digital','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['bank_name'=>'BNI','account_number'=>'0987654321','account_name'=>'PT UndanganKu Digital','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['bank_name'=>'Mandiri','account_number'=>'1122334455','account_name'=>'PT UndanganKu Digital','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── ORDERS ─────────────────────────────────────────────────
        $basicPkg   = DB::table('packages')->where('slug','basic')->value('id');
        $premiumPkg = DB::table('packages')->where('slug','premium')->value('id');
        $luxuryPkg  = DB::table('packages')->where('slug','luxury')->value('id');
        $bca        = DB::table('bank_accounts')->where('bank_name','BCA')->value('id');

        // Insert orders one by one to avoid column count mismatch
        $orderData = [
            ['order_number'=>'UNDANGAN00000001','user_id'=>2,'package_id'=>$luxuryPkg, 'amount'=>299000,'payment_method'=>'bank_transfer','payment_status'=>'paid',  'bank_account_id'=>$bca,'paid_at'=>now()->subDays(25),'notes'=>null,'created_at'=>now()->subDays(26),'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000002','user_id'=>3,'package_id'=>$premiumPkg,'amount'=>150000,'payment_method'=>'bank_transfer','payment_status'=>'paid',  'bank_account_id'=>$bca,'paid_at'=>now()->subDays(18),'notes'=>null,'created_at'=>now()->subDays(19),'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000003','user_id'=>4,'package_id'=>$luxuryPkg, 'amount'=>299000,'payment_method'=>'midtrans',     'payment_status'=>'paid',  'bank_account_id'=>null,'paid_at'=>now()->subDays(12),'notes'=>null,'created_at'=>now()->subDays(13),'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000004','user_id'=>5,'package_id'=>$basicPkg,  'amount'=>75000, 'payment_method'=>'bank_transfer','payment_status'=>'pending','bank_account_id'=>$bca,'paid_at'=>null,'notes'=>'Transfer dari BCA atas nama Andi Firmansyah','created_at'=>now()->subDays(3), 'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000005','user_id'=>6,'package_id'=>$premiumPkg,'amount'=>150000,'payment_method'=>'bank_transfer','payment_status'=>'paid',  'bank_account_id'=>$bca,'paid_at'=>now()->subDays(2), 'notes'=>null,'created_at'=>now()->subDays(3), 'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000006','user_id'=>2,'package_id'=>$luxuryPkg, 'amount'=>299000,'payment_method'=>'bank_transfer','payment_status'=>'pending','bank_account_id'=>$bca,'paid_at'=>null,'notes'=>'Transfer dari BNI, sudah kirim bukti WA','created_at'=>now()->subHours(5),'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000007','user_id'=>3,'package_id'=>$basicPkg,  'amount'=>75000, 'payment_method'=>'bank_transfer','payment_status'=>'pending','bank_account_id'=>$bca,'paid_at'=>null,'notes'=>null,'created_at'=>now()->subHours(2),'updated_at'=>now()],
            ['order_number'=>'UNDANGAN00000008','user_id'=>4,'package_id'=>$basicPkg,  'amount'=>75000, 'payment_method'=>'midtrans',     'payment_status'=>'failed', 'bank_account_id'=>null,'paid_at'=>null,'notes'=>'Sesi expired','created_at'=>now()->subDays(7),'updated_at'=>now()],
        ];
        foreach ($orderData as $row) DB::table('orders')->insert($row);



        // ── INVITATIONS ────────────────────────────────────────────
        $order1  = DB::table('orders')->where('order_number','UNDANGAN00000001')->value('id');
        $order2  = DB::table('orders')->where('order_number','UNDANGAN00000002')->value('id');
        $order3  = DB::table('orders')->where('order_number','UNDANGAN00000003')->value('id');
        $order5  = DB::table('orders')->where('order_number','UNDANGAN00000005')->value('id');
        $tGolden = DB::table('templates')->where('slug','golden-garden')->value('id');
        $tRoyal  = DB::table('templates')->where('slug','royal-blue')->value('id');
        $tCrimson= DB::table('templates')->where('slug','crimson-petal')->value('id');
        $tSakura = DB::table('templates')->where('slug','sakura-bloom')->value('id');
        $tSage   = DB::table('templates')->where('slug','midnight-sage')->value('id');

        // Helper: all invitation columns explicitly mapped
        $inv = function($d) {
            return array_merge([
                'status'=>'active','groom_photo'=>null,'bride_photo'=>null,'cover_photo'=>null,
                'groom_bio'=>null,'bride_bio'=>null,'groom_instagram'=>null,'bride_instagram'=>null,
                'akad_date'=>null,'akad_time_start'=>null,'akad_time_end'=>null,
                'akad_venue'=>null,'akad_address'=>null,'akad_maps_url'=>null,
                'resepsi_date'=>null,'resepsi_time_start'=>null,'resepsi_time_end'=>null,
                'resepsi_venue'=>null,'resepsi_address'=>null,'resepsi_maps_url'=>null,
                'resepsi_same_as_akad'=>false,'opening_text'=>null,'closing_text'=>null,
                'love_story'=>null,'love_story_items'=>null,'music_file'=>null,
                'selected_music_key'=>null,'music_autoplay'=>true,'livestream_url'=>null,
                'invitation_message'=>null,'color_primary'=>'#C1826A','color_secondary'=>'#EFE5D8',
                'font_family'=>'Fraunces','created_at'=>now(),'updated_at'=>now(),
            ], $d);
        };

        DB::table('invitations')->insert([
            $inv([
                'user_id'=>2,'order_id'=>$order1,'template_id'=>$tGolden,
                'slug'=>'reza-vina-2026','title'=>'Reza & Vina','status'=>'active',
                'groom_name'=>'Muhammad Reza Pratama, S.T.','groom_nickname'=>'Reza',
                'groom_father'=>'Ir. Hendra Pratama','groom_mother'=>'Dra. Sri Wahyuni',
                'bride_name'=>'Vina Aulia Rahmawati, S.E.','bride_nickname'=>'Vina',
                'bride_father'=>'H. Bambang Setiawan','bride_mother'=>'Hj. Nining Rahayu',
                'akad_date'=>'2026-08-09','akad_time_start'=>'08:00','akad_time_end'=>'10:00',
                'akad_venue'=>'Masjid Al-Ikhlas Pondok Indah','akad_address'=>'Jl. Metro Pondok Indah No.1, Jakarta Selatan',
                'akad_maps_url'=>'https://maps.google.com/',
                'resepsi_date'=>'2026-08-09','resepsi_time_start'=>'11:00','resepsi_time_end'=>'15:00',
                'resepsi_venue'=>'The Ritz-Carlton Jakarta, Pacific Place','resepsi_address'=>'Jl. Jend. Sudirman Kav. 52-53, Jakarta',
                'resepsi_maps_url'=>'https://maps.google.com/',
                'opening_text'=>"Dengan memohon ridha dan rahmat Allah SWT\nkami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan do'a restu.",
                'closing_text'=>"Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir\ndan memberikan do'a restu kepada kami.",
                'invitation_message'=>"Assalamualaikum Warahmatullahi Wabarakatuh,\nKepada Yth. *{nama_tamu}*\n\nKami mengundang kehadiran Bapak/Ibu/Saudara/i.\n\nLink: {link_undangan}\n\n*{nama_pengantin_pria}* & *{nama_pengantin_wanita}*",
                'color_primary'=>'#C49A3C','color_secondary'=>'#2C1A0A','font_family'=>'Gloock',
                'love_story_items'=>json_encode([
                    ['title'=>'Pertama Bertemu','date'=>'Maret 2019','content'=>'Kami bertemu di sebuah seminar bisnis di Jakarta. Percakapan singkat yang menjadi awal dari segalanya.'],
                    ['title'=>'Kencan Pertama','date'=>'Mei 2019','content'=>'Reza mengajak Vina makan malam di restoran rooftop yang romantis. Malam yang tidak terlupakan.'],
                    ['title'=>'Resmi Berpacaran','date'=>'Agustus 2019','content'=>'Dengan segenap keberanian, Reza akhirnya mengungkapkan perasaannya. Vina pun menerima.'],
                    ['title'=>'Lamaran','date'=>'Desember 2025','content'=>'Di hadapan keluarga, Reza melamar Vina dengan cincin berlian. Air mata bahagia mengalir.'],
                    ['title'=>'Menuju Pernikahan','date'=>'Agustus 2026','content'=>'Kami siap memulai babak baru bersama, dengan ridha Allah dan doa semua keluarga.'],
                ]),
                'music_autoplay'=>true,'couple_order'=>'bride_first','created_at'=>now()->subDays(24),
            ]),
            $inv([
                'user_id'=>3,'order_id'=>$order2,'template_id'=>$tRoyal,
                'slug'=>'bagas-nurul-2026','title'=>'Bagas & Nurul','status'=>'active',
                'groom_name'=>'Bagas Setiawan, S.Kom.','groom_nickname'=>'Bagas',
                'groom_father'=>'Drs. Agus Setiawan','groom_mother'=>'Ir. Dewi Ratnasari',
                'bride_name'=>'Nurul Hidayah, S.Pd.','bride_nickname'=>'Nurul',
                'bride_father'=>'H. Zainuddin Fauzi','bride_mother'=>'Hj. Rahmawati',
                'akad_date'=>'2026-09-20','akad_time_start'=>'09:00','akad_time_end'=>'11:00',
                'akad_venue'=>'Masjid Agung Al-Azhar','akad_address'=>'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan',
                'akad_maps_url'=>'https://maps.google.com/',
                'resepsi_date'=>'2026-09-20','resepsi_time_start'=>'12:00','resepsi_time_end'=>'17:00',
                'resepsi_venue'=>'Ballroom Hotel Sultan','resepsi_address'=>'Jl. Gatot Subroto, Jakarta Selatan',
                'resepsi_maps_url'=>'https://maps.google.com/',
                'opening_text'=>"Bismillahirrahmanirrahim\nAssalamualaikum Warahmatullahi Wabarakatuh\n\nDengan memohon ridha Allah SWT, kami mengundang Bapak/Ibu/Saudara/i.",
                'closing_text'=>"Tanpa mengurangi rasa hormat, merupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.",
                'invitation_message'=>"Kepada *{nama_tamu}*\n\nYuk hadir di hari bahagia kami! 💍\n\nLink: {link_undangan}\n\n{nama_pengantin_pria} & {nama_pengantin_wanita}",
                'color_primary'=>'#BFA16A','color_secondary'=>'#0E0E0E','font_family'=>'DM Serif Display',
                'love_story_items'=>json_encode([
                    ['title'=>'Bertemu di Kampus','date'=>'2017','content'=>'Kami bertemu di Universitas Indonesia, sama-sama aktif di UKM fotografi.'],
                    ['title'=>'Teman Dekat','date'=>'2018-2020','content'=>'Bertahun-tahun menjadi sahabat terbaik. Selalu ada di saat susah maupun senang.'],
                    ['title'=>'Jadian','date'=>'Februari 2021','content'=>'Di momen istimewa, Bagas mengutarakan perasaan yang sudah lama tersimpan.'],
                    ['title'=>'Lamaran','date'=>'Januari 2026','content'=>'Bagas melamar Nurul di hadapan kedua keluarga dengan penuh haru dan kebahagiaan.'],
                ]),
                'music_autoplay'=>true,'couple_order'=>'groom_first','created_at'=>now()->subDays(17),
            ]),
            $inv([
                'user_id'=>4,'order_id'=>$order3,'template_id'=>$tCrimson,
                'slug'=>'dimas-nayla-2026','title'=>'Dimas & Nayla','status'=>'active',
                'groom_name'=>'Dimas Ardiansyah, S.H.','groom_nickname'=>'Dimas',
                'groom_father'=>'Prof. Dr. Hendra Budiman','groom_mother'=>'Dr. Lestari Wulandari',
                'bride_name'=>'Nayla Zahra Maulida, M.Psi.','bride_nickname'=>'Nayla',
                'bride_father'=>'Drs. Zainal Abidin','bride_mother'=>'Dr. Rahma Dewi',
                'akad_date'=>'2026-10-10','akad_time_start'=>'08:30','akad_time_end'=>'10:30',
                'akad_venue'=>'Masjid Istiqlal','akad_address'=>'Jl. Veteran No.1, Ps. Baru, Jakarta Pusat',
                'akad_maps_url'=>'https://maps.google.com/',
                'resepsi_date'=>'2026-10-10','resepsi_time_start'=>'18:00','resepsi_time_end'=>'22:00',
                'resepsi_venue'=>'Grand Ballroom Mandarin Oriental','resepsi_address'=>'Jl. M.H. Thamrin, Jakarta Pusat',
                'resepsi_maps_url'=>'https://maps.google.com/',
                'opening_text'=>"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya.\n(QS. Ar-Rum: 21)",
                'closing_text'=>"Dengan segala kerendahan hati, kami memohon kehadiran dan doa restu di hari istimewa kami.",
                'invitation_message'=>"Assalamualaikum,\nKepada *{nama_tamu}*\n\nKami mengundang kehadiran Anda.\n\nLink: {link_undangan}\n\n*{nama_pengantin_pria}* & *{nama_pengantin_wanita}*",
                'color_primary'=>'#B5496A','color_secondary'=>'#C8956A','font_family'=>'Cormorant Garamond',
                'love_story_items'=>json_encode([
                    ['title'=>'Kenal di Acara Hukum','date'=>'2018','content'=>'Bertemu di seminar hukum internasional. Percakapan panjang tentang hukum dan kehidupan pun dimulai.'],
                    ['title'=>'Long Distance','date'=>'2019-2021','content'=>'Dimas di Jakarta, Nayla di Belanda untuk S2. Video call setiap hari menjaga api cinta.'],
                    ['title'=>'Reuni & Kepastian','date'=>'2022','content'=>'Nayla kembali ke Indonesia. Dimas menjemput di bandara dengan seikat mawar merah.'],
                    ['title'=>'Lamaran di Paris','date'=>'Desember 2025','content'=>'Dimas melamar di Menara Eiffel saat malam tahun baru. Momen paling magis dalam hidup keduanya.'],
                ]),
                'music_autoplay'=>true,'couple_order'=>'bride_first','created_at'=>now()->subDays(11),
            ]),
            $inv([
                'user_id'=>6,'order_id'=>$order5,'template_id'=>$tSage,
                'slug'=>'farel-sinta-2026','title'=>'Farel & Sinta','status'=>'active',
                'groom_name'=>'Farel Prayoga, S.T.','groom_nickname'=>'Farel',
                'groom_father'=>'H. Prayoga Santoso','groom_mother'=>'Hj. Mutiara Dewi',
                'bride_name'=>'Sinta Maharani, S.E.','bride_nickname'=>'Sinta',
                'bride_father'=>'Bpk. Maharani Kusuma','bride_mother'=>'Ibu Endah Lestari',
                'akad_date'=>'2026-11-15','akad_time_start'=>'09:00','akad_time_end'=>'11:00',
                'akad_venue'=>'Masjid Raya Bogor','akad_address'=>'Jl. Pajajaran No.8, Bogor Tengah',
                'akad_maps_url'=>'https://maps.google.com/',
                'resepsi_date'=>'2026-11-15','resepsi_time_start'=>'12:00','resepsi_time_end'=>'16:00',
                'resepsi_venue'=>'Gedung Serba Guna Botani Square','resepsi_address'=>'Jl. Pajajaran No.23, Bogor',
                'resepsi_maps_url'=>'https://maps.google.com/',
                'opening_text'=>"Dengan penuh syukur kepada Allah SWT\nkami mengundang Bapak/Ibu/Saudara/i untuk turut berbahagia bersama kami.",
                'closing_text'=>"Kehadiran dan doa restu Bapak/Ibu/Saudara/i adalah kebahagiaan terbesar bagi kami.",
                'invitation_message'=>"Halo *{nama_tamu}* 👋\n\nYuk hadir di hari spesial kami! 🎊\n\nLink: {link_undangan}\n\n{nama_pengantin_pria} & {nama_pengantin_wanita}",
                'color_primary'=>'#4A7C59','color_secondary'=>'#2C3E2D','font_family'=>'Libre Baskerville',
                'love_story_items'=>json_encode([
                    ['title'=>'Bertemu via Teman','date'=>'2020','content'=>'Dipertemukan melalui teman bersama di sebuah arisan keluarga.'],
                    ['title'=>'PDKT','date'=>'2021','content'=>'Setahun penuh PDKT sampai Farel memberanikan diri mengajak ketemuan.'],
                    ['title'=>'Resmi Bersama','date'=>'Maret 2022','content'=>'Hubungan resmi di bawah pohon rindang di Kebun Raya Bogor.'],
                    ['title'=>'Lamaran','date'=>'Mei 2026','content'=>'Dengan restu kedua keluarga, babak baru pun dimulai.'],
                ]),
                'music_autoplay'=>false,'couple_order'=>'groom_first','created_at'=>now()->subDays(2),
            ]),
            // Draft without order (user 5)
            $inv([
                'user_id'=>5,'order_id'=>null,'template_id'=>$tSakura,
                'slug'=>'andi-maya-draft','title'=>'Andi & Maya','status'=>'draft',
                'groom_name'=>'Andi Firmansyah','groom_nickname'=>'Andi',
                'groom_father'=>'Bpk. Firmansyah','groom_mother'=>'Ibu Rahayu',
                'bride_name'=>'Maya Sari','bride_nickname'=>'Maya',
                'bride_father'=>'Bpk. Santoso','bride_mother'=>'Ibu Lestari',
                'color_primary'=>'#C1826A','color_secondary'=>'#EFE5D8','font_family'=>'Fraunces',
                'music_autoplay'=>false,'couple_order'=>'bride_first','created_at'=>now()->subDays(8),
            ]),
        ]);

        // ── GUESTS ─────────────────────────────────────────────────
        $inv1 = DB::table('invitations')->where('slug','reza-vina-2026')->value('id');
        $inv2 = DB::table('invitations')->where('slug','bagas-nurul-2026')->value('id');
        $inv3 = DB::table('invitations')->where('slug','dimas-nayla-2026')->value('id');

        foreach ([
            [$inv1,'Bapak Ahmad Dahlan','6281234000001','hadir',2],
            [$inv1,'Keluarga Besar Pratama','6281234000002','hadir',4],
            [$inv1,'Ibu Sari Dewi','6281234000003','hadir',1],
            [$inv1,'Rombongan SMAN 1 Jakarta','6281234000004','hadir',8],
            [$inv1,'Pak Budi Santoso','6281234000005','tidak_hadir',2],
            [$inv1,'Keluarga Pak Hendra','6281234000006','pending',3],
            [$inv1,'Tim Kantor Reza','6281234000007','hadir',5],
            [$inv1,'Bu Wulandari & Keluarga','6281234000008','hadir',3],
            [$inv2,'Keluarga Pak Agus','6281234000009','hadir',4],
            [$inv2,'Teman Kuliah UI','6281234000010','hadir',6],
            [$inv2,'Bu Rahayu','6281234000011','pending',2],
            [$inv2,'Tim Departemen Pendidikan','6281234000012','hadir',3],
            [$inv3,'Keluarga Prof. Hendra','6281234000013','hadir',5],
            [$inv3,'Rekan Pengacara','6281234000014','hadir',2],
            [$inv3,'Alumni FH UI 2018','6281234000015','hadir',10],
        ] as [$invId,$name,$phone,$status,$pax]) {
            DB::table('guests')->insert(['invitation_id'=>$invId,'name'=>$name,'phone'=>$phone,'status'=>$status,'pax'=>$pax,'created_at'=>now()->subDays(rand(1,20)),'updated_at'=>now()]);
        }

        // ── RSVP ───────────────────────────────────────────────────
        foreach ([
            [$inv1,'Bapak Ahmad Dahlan','6281234000001','hadir',2,"Selamat! Semoga menjadi keluarga sakinah mawaddah warahmah."],
            [$inv1,'Ibu Sari Dewi','6281234000003','hadir',1,"Insyaallah hadir, selamat untuk Reza dan Vina!"],
            [$inv1,'Pak Budi Santoso','6281234000005','tidak_hadir',2,"Maaf tidak bisa hadir, semoga lancar acaranya!"],
            [$inv2,'Keluarga Pak Agus','6281234000009','hadir',4,"Siap hadir, barakallah untuk kalian berdua!"],
            [$inv3,'Rekan Pengacara','6281234000014','hadir',2,"Selamat dan bahagia selalu!"],
        ] as [$invId,$name,$phone,$attend,$pax,$msg]) {
            DB::table('rsvps')->insert(['invitation_id'=>$invId,'name'=>$name,'phone'=>$phone,'attendance'=>$attend,'pax'=>$pax,'message'=>$msg,'created_at'=>now()->subDays(rand(1,15)),'updated_at'=>now()]);
        }

        // ── WISHES ─────────────────────────────────────────────────
        foreach ([
            [$inv1,'Bapak Hendra Kurniawan',"Alhamdulillah... selamat menempuh hidup baru! Semoga menjadi keluarga sakinah, mawaddah, warahmah. Barakallah fiikuma.",true],
            [$inv1,'Ibu Dewi Susanti',"Selamat ya Reza dan Vina! Kalian pasangan yang serasi. Semoga rumah tangga penuh berkah dan kebahagiaan!",true],
            [$inv1,'Tim Marketing Brilian',"Selamat boss Reza! Akhirnya sah juga. Semoga bahagia selalu bersama Vina.",true],
            [$inv1,'Keluarga Besar Pranoto',"Barakallahu lakuma wa baraka alaikuma wa jama a bainakuma fi khair. Aamiin ya Rabb.",true],
            [$inv1,'Sahabat SMA Geng Elang',"Woooh akhirnya kalian resmi!!! Langgeng sampai kakek nenek!",true],
            [$inv1,'Ustadz Muhammad Iqbal',"Semoga Allah SWT memberikan berkah kepada pengantin, mempererat tali kasih di antara keduanya. Aamiin.",true],
            [$inv2,'Keluarga Pak Santosa',"Selamat menempuh hidup baru Bagas dan Nurul! Semoga menjadi keluarga yang bahagia.",true],
            [$inv2,'Alumni UKM Foto UI',"Congratulations!! Pasangan fotografer terbaik kampus akhirnya bersatu juga. Bahagia selalu!",true],
            [$inv3,'Prof. Dr. Budiman Santoso',"Selamat untuk Dimas dan Nayla. Perjalanan panjang kalian akhirnya berbuah indah.",true],
            [$inv3,'Keluarga Zainal Abidin',"Alhamdulillah, selamat ya Dimas dan Nayla. Doa kami selalu menyertai kalian. Aamiin.",true],
        ] as [$invId,$name,$msg,$visible]) {
            DB::table('wishes')->insert(['invitation_id'=>$invId,'name'=>$name,'message'=>$msg,'is_visible'=>$visible,'created_at'=>now()->subDays(rand(1,20)),'updated_at'=>now()]);
        }

        // ── GIFTS (REKENING) ───────────────────────────────────────
        DB::table('invitation_gifts')->insert([
            ['invitation_id'=>$inv1,'bank_name'=>'BCA','account_number'=>'1234567890','account_name'=>'Muhammad Reza Pratama','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>$inv1,'bank_name'=>'GoPay','account_number'=>'08123456789','account_name'=>'Reza Pratama','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>$inv2,'bank_name'=>'BNI','account_number'=>'0987654321','account_name'=>'Bagas Setiawan','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>$inv3,'bank_name'=>'Mandiri','account_number'=>'1122334455','account_name'=>'Dimas Ardiansyah','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>$inv3,'bank_name'=>'OVO','account_number'=>'08567890123','account_name'=>'Nayla Zahra','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── PRESET MUSICS ──────────────────────────────────────────
        DB::table('preset_musics')->insert([
            ['title'=>'A Thousand Years','artist'=>'Christina Perri','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3','is_active'=>true,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Perfect','artist'=>'Ed Sheeran','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3','is_active'=>true,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Can\'t Help Falling in Love','artist'=>'Elvis Presley','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3','is_active'=>true,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'All of Me','artist'=>'John Legend','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3','is_active'=>true,'sort_order'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Thinking Out Loud','artist'=>'Ed Sheeran','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3','is_active'=>true,'sort_order'=>5,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Marry You','artist'=>'Bruno Mars','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-6.mp3','is_active'=>true,'sort_order'=>6,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'At Last','artist'=>'Etta James','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3','is_active'=>true,'sort_order'=>7,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Bless the Broken Road','artist'=>'Rascal Flatts','file_url'=>'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3','is_active'=>true,'sort_order'=>8,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── PORTFOLIOS ─────────────────────────────────────────────
        // Columns: invitation_id(nullable), couple_name, photo, demo_url, package_name, rating, testimonial, is_visible
        DB::table('portfolios')->insert([
            ['invitation_id'=>null,'couple_name'=>'Reza & Vina','photo'=>'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Luxury','rating'=>5,'testimonial'=>'Template luxury-nya luar biasa! Banyak tamu yang nanya beli undangan digitalnya dimana. Langsung ku rekomendasiin UndanganKu!','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>null,'couple_name'=>'Bagas & Nurul','photo'=>'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Premium','rating'=>5,'testimonial'=>'Prosesnya mudah banget, hasilnya kece. Admin responsif. Recommended!','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>null,'couple_name'=>'Dimas & Nayla','photo'=>'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Luxury','rating'=>5,'testimonial'=>'Fitur RSVP berguna banget buat ngitung tamu. Hemat waktu dan kertas!','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>null,'couple_name'=>'Andi & Maya','photo'=>'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Premium','rating'=>5,'testimonial'=>'Desainnya keren dan responsif di HP. Link undangan langsung bisa dishare ke WA.','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>null,'couple_name'=>'Hendra & Lina','photo'=>'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Basic','rating'=>4,'testimonial'=>'Simple tapi cantik. Harga terjangkau untuk kualitas yang bagus!','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['invitation_id'=>null,'couple_name'=>'Farel & Sinta','photo'=>'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600&h=400&fit=crop&q=80','demo_url'=>null,'package_name'=>'Luxury','rating'=>5,'testimonial'=>'Amazing! Animasinya halus dan loading cepat. Semua tamu takjub lihat undangan kami.','is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── TESTIMONIALS (public homepage) ─────────────────────────
        // Columns: name, couple, photo, content, rating, is_visible, sort_order  (NO user_id)
        DB::table('testimonials')->insert([
            ['name'=>'Reza & Vina','couple'=>'Reza & Vina','photo'=>null,'content'=>'Pelayanannya luar biasa! Template luxury-nya bikin tamu kagum semua. Proses dari order sampai aktif cuma 2 jam!','rating'=>5,'is_visible'=>true,'sort_order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Bagas & Nurul','couple'=>'Bagas & Nurul','photo'=>null,'content'=>'Mudah banget pakainya, bisa edit sendiri dari HP. Fitur RSVP sangat membantu tracking tamu undangan.','rating'=>5,'is_visible'=>true,'sort_order'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Dimas & Nayla','couple'=>'Dimas & Nayla','photo'=>null,'content'=>'Worth every penny! Template luxury kami dapat banyak pujian dari tamu. Recommend banget!','rating'=>5,'is_visible'=>true,'sort_order'=>3,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Andi & Maya','couple'=>'Andi & Maya','photo'=>null,'content'=>'Responsif di semua perangkat. Proses upload foto mudah. Admin juga sangat membantu.','rating'=>4,'is_visible'=>true,'sort_order'=>4,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── USER TESTIMONIALS (from orders, needs order_id) ────────
        // Columns: order_id, user_id, content, rating, allow_portfolio, status
        $ord1 = DB::table('orders')->where('order_number','UNDANGAN00000001')->value('id');
        $ord2 = DB::table('orders')->where('order_number','UNDANGAN00000002')->value('id');
        DB::table('user_testimonials')->insert([
            ['order_id'=>$ord1,'user_id'=>2,'content'=>'Template luxury-nya keren banget! Proses cepat dan admin responsif. Highly recommended!','rating'=>5,'allow_portfolio'=>true,'status'=>'approved','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>$ord2,'user_id'=>3,'content'=>'Fitur RSVP sangat membantu. Desain premium-nya elegan dan loading cepat di semua HP.','rating'=>5,'allow_portfolio'=>true,'status'=>'approved','created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── FAQs ───────────────────────────────────────────────────
        // Columns: question, answer, sort_order, is_visible  (NO is_active)
        DB::table('faqs')->insert([
            ['question'=>'Bagaimana cara membuat undangan digital?','answer'=>'Sangat mudah! Daftar akun, pilih paket, buat undangan, isi data pengantin dan acara, pilih template, lalu bagikan link ke tamu. Proses bisa selesai dalam 30 menit.','sort_order'=>1,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Berapa lama undangan bisa diakses?','answer'=>'Undangan bisa diakses selamanya selama akun masih aktif. Tidak ada batas waktu untuk semua paket.','sort_order'=>2,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Apakah bisa ganti template setelah bayar?','answer'=>'Bisa! Kamu bisa ganti template kapan saja selama template tersebut termasuk dalam kategori paket yang kamu pilih.','sort_order'=>3,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Bagaimana cara pembayaran?','answer'=>'Tersedia 2 cara: Payment Gateway (Midtrans) untuk QRIS, GoPay, OVO, transfer bank, dan kartu kredit. Atau Transfer Manual ke rekening kami.','sort_order'=>4,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Apakah undangan bisa diedit setelah aktif?','answer'=>'Ya, kamu bisa edit undangan kapan saja. Semua perubahan langsung tersimpan dan terlihat tamu secara real-time.','sort_order'=>5,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Berapa batas maksimal tamu?','answer'=>'Paket Basic: 100 tamu, Paket Premium: 500 tamu, Paket Luxury: tidak terbatas.','sort_order'=>6,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Apakah ada fitur RSVP?','answer'=>'Ya! Semua paket dilengkapi fitur RSVP. Tamu bisa konfirmasi kehadiran dan kamu bisa melihat rekapitulasinya di dashboard.','sort_order'=>7,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['question'=>'Bisakah membuat lebih dari 1 undangan?','answer'=>'Bisa! Setiap undangan memerlukan paket sendiri-sendiri. Kamu bisa membuat draft undangan terlebih dahulu sebelum memilih paket.','sort_order'=>8,'is_visible'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
