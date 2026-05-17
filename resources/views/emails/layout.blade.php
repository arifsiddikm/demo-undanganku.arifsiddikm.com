<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $subject ?? 'UndanganKu' }}</title>
</head>
<body style="margin:0;padding:0;background:#F9FAFB;font-family:'Segoe UI',Arial,sans-serif;-webkit-font-smoothing:antialiased">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#F9FAFB;padding:32px 16px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

  {{-- HEADER --}}
  <tr><td style="background:linear-gradient(135deg,#BE185D 0%,#F472B6 50%,#A78BFA 100%);border-radius:20px 20px 0 0;padding:40px 32px;text-align:center">
    <div style="font-size:36px;margin-bottom:8px">💍</div>
    <div style="color:white;font-size:22px;font-weight:700;letter-spacing:0.5px;font-family:Georgia,serif">UndanganKu</div>
    <div style="color:rgba(255,255,255,0.75);font-size:13px;margin-top:4px">Platform Undangan Digital</div>
  </td></tr>

  {{-- BODY --}}
  <tr><td style="background:white;padding:36px 36px 24px;border-left:1px solid #F3E8FF;border-right:1px solid #F3E8FF">
    @yield('body')
  </td></tr>

  {{-- FOOTER --}}
  <tr><td style="background:#1F2937;border-radius:0 0 20px 20px;padding:24px 32px;text-align:center">
    <div style="color:rgba(255,255,255,0.6);font-size:12px;line-height:1.8">
      <strong style="color:rgba(255,255,255,0.9)">UndanganKu</strong> — Platform Undangan Digital Indonesia<br>
      <a href="https://www.instagram.com/arifsiddikm/" style="color:#F472B6;text-decoration:none">@arifsiddikm</a>
      &nbsp;·&nbsp; <a href="{{ url('/') }}" style="color:rgba(255,255,255,0.5);text-decoration:none">{{ url('/') }}</a>
    </div>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
