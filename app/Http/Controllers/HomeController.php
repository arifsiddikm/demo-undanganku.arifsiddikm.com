<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Portfolio;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $templates     = Template::where('is_active', true)->orderBy('sort_order')->take(3)->get();
        $packages      = Package::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials  = Testimonial::where('is_visible', true)->orderBy('sort_order')->take(3)->get();
        $portfolios    = Portfolio::where('is_visible', true)->latest()->take(4)->get();
        $faqs          = Faq::where('is_visible', true)->orderBy('sort_order')->get();
        $templateCount = Template::where('is_active', true)->count();

        return view('home.index', compact('templates', 'packages', 'testimonials', 'portfolios', 'faqs', 'templateCount'));
    }

    public function portfolio()
    {
        $portfolios   = Portfolio::where('is_visible', true)->latest()->paginate(12);
        $testimonials = Testimonial::where('is_visible', true)->orderBy('sort_order')->take(4)->get();
        return view('home.portfolio', compact('portfolios', 'testimonials'));
    }

    public function templates()
    {
        $templates     = Template::where('is_active', true)->orderBy('category')->orderBy('sort_order')->get();
        $packages      = Package::where('is_active', true)->orderBy('sort_order')->get();
        $templateCount = Template::where('is_active', true)->count();
        return view('home.templates', compact('templates', 'packages', 'templateCount'));
    }

    public function previewTemplate($slug)
    {
        $template = Template::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $fp = ltrim(str_replace('templates/', '', $template->file_path ?? 'sakura-bloom'), '/');

        // Build a dummy invitation for preview so template doesn't throw undefined variable
        $invitation = new \App\Models\Invitation([
            'title'          => 'Preview: ' . $template->name,
            'slug'           => 'preview-demo',
            'status'         => 'active',
            'template_id'    => $template->id,
            'groom_name'     => 'Nama Pengantin Pria',
            'groom_nickname' => 'Pria',
            'groom_father'   => 'Bapak Ayah',
            'groom_mother'   => 'Ibu Mama',
            'bride_name'     => 'Nama Pengantin Wanita',
            'bride_nickname' => 'Wanita',
            'bride_father'   => 'Bapak Ayah',
            'bride_mother'   => 'Ibu Mama',
            'akad_date'      => now()->addMonths(2)->format('Y-m-d'),
            'akad_time_start'=> '08:00',
            'akad_time_end'  => '10:00',
            'akad_venue'     => 'Masjid Al-Ikhlas',
            'akad_address'   => 'Jl. Contoh No. 1, Jakarta',
            'resepsi_date'   => now()->addMonths(2)->format('Y-m-d'),
            'resepsi_time_start' => '11:00',
            'resepsi_time_end'   => '15:00',
            'resepsi_venue'      => 'Gedung Serbaguna',
            'resepsi_address'    => 'Jl. Contoh No. 1, Jakarta',
            'opening_text'   => 'Dengan memohon ridha dan rahmat Allah SWT, kami mengundang kehadiran Bapak/Ibu/Saudara/i.',
            'closing_text'   => 'Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.',
            'color_primary'  => $template->primary_color,
            'color_secondary'=> $template->secondary_color,
            'music_autoplay' => false,
        ]);
        $invitation->id = 0;
        // attach template relation
        $invitation->setRelation('template', $template);
        $invitation->setRelation('photos', collect());
        $invitation->setRelation('gifts', collect());
        $invitation->setRelation('guests', collect());

        return view('templates.' . $fp, [
            'invitation' => $invitation,
            'template'   => $template,
            'isPreview'  => true,
            'guestName'  => '',
        ]);
    }
}
