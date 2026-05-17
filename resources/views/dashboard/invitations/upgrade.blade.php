@extends('layouts.dashboard')
@section('title', 'Upgrade Undangan')
@section('page_title', 'Upgrade Paket')

@section('content')
<div style="max-width:800px;">
  <div style="background:linear-gradient(135deg,#FDF2F8,#EFF6FF);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;border:1px solid rgba(244,114,182,.15);">
    <div style="font-size:0.78rem;color:var(--color-muted);margin-bottom:0.25rem;">Upgrade untuk undangan:</div>
    <div style="font-weight:700;font-size:1.1rem;">{{ $invitation->title }}</div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:1.5rem;">
    @foreach($packages as $pkg)
    @php
      $colors = [
        'basic'   => ['border'=>'#E5E7EB','bg'=>'white','accent'=>'#6B7280','badge'=>'#F9FAFB','icon'=>'✨'],
        'premium' => ['border'=>'#7C3AED','bg'=>'#F5F3FF','accent'=>'#6D28D9','badge'=>'#EDE9FE','icon'=>'💎'],
        'luxury'  => ['border'=>'#C49A3C','bg'=>'#FFFBEB','accent'=>'#92400E','badge'=>'#FEF3C7','icon'=>'👑'],
      ];
      $c = $colors[$pkg->slug] ?? $colors['basic'];
    @endphp
    <div style="border:2px solid {{ $c['border'] }};border-radius:16px;padding:1.5rem;background:{{ $c['bg'] }};position:relative;">
      @if($pkg->slug === 'premium')
      <div style="position:absolute;top:-10px;left:50%;transform:translateX(-50%);background:#7C3AED;color:white;font-size:0.62rem;font-weight:700;padding:0.2rem 0.75rem;border-radius:20px;letter-spacing:.06em;white-space:nowrap;">POPULER</div>
      @endif
      <div style="font-size:1.5rem;margin-bottom:0.5rem;">{{ $c['icon'] }}</div>
      <div style="font-weight:700;font-size:1rem;color:{{ $c['accent'] }};margin-bottom:0.25rem;">{{ $pkg->name }}</div>
      <div style="font-size:1.4rem;font-weight:800;margin-bottom:0.85rem;">Rp {{ number_format($pkg->price,0,',','.') }}</div>
      @if($pkg->features)
      @php $feats = is_array($pkg->features) ? $pkg->features : json_decode($pkg->features, true) ?? []; @endphp
      <ul style="list-style:none;margin-bottom:1.25rem;">
        @foreach(array_slice($feats, 0, 5) as $feat)
        <li style="font-size:0.78rem;color:var(--color-muted);padding:0.2rem 0;display:flex;gap:0.4rem;align-items:flex-start;">
          <span style="color:{{ $c['accent'] }};font-size:0.7rem;margin-top:2px;">✓</span> {{ $feat }}
        </li>
        @endforeach
      </ul>
      @endif
      <a href="{{ route('checkout.invitation', [$pkg->slug, $invitation->id]) }}"
        style="display:block;text-align:center;background:{{ $c['accent'] }};color:white;padding:0.7rem;border-radius:10px;text-decoration:none;font-weight:600;font-size:0.85rem;transition:opacity .2s;"
        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        Pilih {{ $pkg->name }} →
      </a>
    </div>
    @endforeach
  </div>

  <a href="{{ route('invitations.index') }}" class="btn-outline">← Kembali</a>
</div>
@endsection
