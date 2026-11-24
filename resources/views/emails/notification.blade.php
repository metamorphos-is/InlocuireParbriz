{{-- Email HTML (tabele + stiluri inline, pentru Gmail/Outlook/telefon). Variabile:
     $preheader, $kicker, $title, $intro (paragrafe), $rows [[label, value]], $buttons [[label, url, primary]], $note, $reference --}}
@php
    $brand = \App\Support\Company::display()['brand'] ?? 'inlocuireparbriz.ro';
    $site = rtrim(config('inlocuireparbriz.canonical_url', 'https://inlocuireparbriz.ro'), '/');
@endphp
<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light">
<title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background:#EEF1F6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#101827;">
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $preheader ?? $title }}</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#EEF1F6;">
<tr><td align="center" style="padding:28px 12px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;">
        {{-- antet --}}
        <tr><td style="padding:0 4px 16px;">
            <table role="presentation" cellpadding="0" cellspacing="0"><tr>
                <td style="width:40px;height:40px;background:#101827;border-radius:10px;text-align:center;vertical-align:middle;">
                    <img src="{{ $site }}/assets/img/icon-192.png" width="40" height="40" alt="" style="display:block;border-radius:10px;">
                </td>
                <td style="padding-left:10px;font-size:18px;font-weight:800;color:#101827;">inlocuire<span style="color:#FF702B;">parbriz</span><span style="color:#64748B;font-weight:600;">.ro</span></td>
            </tr></table>
        </td></tr>

        {{-- card --}}
        <tr><td style="background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(16,24,39,.08);">
            <div style="height:5px;background:#FF702B;background:linear-gradient(90deg,#FF702B,#FFB27D);"></div>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr><td style="padding:28px 28px 8px;">
                    @if (! empty($kicker))
                        <div style="display:inline-block;padding:5px 12px;border-radius:999px;background:#FFF1E8;color:#C2410C;font-size:12px;font-weight:700;">{{ $kicker }}</div>
                    @endif
                    <h1 style="margin:14px 0 6px;font-size:22px;line-height:1.3;font-weight:800;color:#101827;">{{ $title }}</h1>
                    @if (! empty($reference))
                        <div style="font-size:13px;color:#64748B;">Referință: <strong style="color:#101827;">{{ $reference }}</strong></div>
                    @endif
                </td></tr>

                @if (! empty($intro))
                <tr><td style="padding:10px 28px 4px;font-size:15px;line-height:1.65;color:#334155;">
                    @foreach (preg_split("/\n\s*\n|\n/", trim($intro)) as $p)
                        @if (trim($p) !== '')<p style="margin:0 0 10px;">{{ $p }}</p>@endif
                    @endforeach
                </td></tr>
                @endif

                @if (! empty($buttons))
                <tr><td style="padding:12px 28px 6px;">
                    @foreach ($buttons as [$label, $url, $primary])
                        <a href="{{ $url }}" style="display:inline-block;margin:0 8px 10px 0;padding:12px 20px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;{{ $primary ? 'background:#FF702B;color:#FFFFFF;' : 'background:#FFFFFF;color:#1B4FBF;border:1px solid #CBD5E1;' }}">{{ $label }}</a>
                    @endforeach
                </td></tr>
                @endif

                @if (! empty($rows))
                <tr><td style="padding:10px 28px 8px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E2E8F0;border-radius:12px;border-collapse:separate;overflow:hidden;">
                        @foreach ($rows as $i => [$label, $value])
                            <tr style="background:{{ $i % 2 ? '#FFFFFF' : '#F8FAFC' }};">
                                <td style="padding:10px 14px;width:38%;font-size:13px;color:#64748B;vertical-align:top;border-bottom:1px solid #EEF2F7;">{{ $label }}</td>
                                <td style="padding:10px 14px;font-size:14px;color:#101827;font-weight:600;vertical-align:top;border-bottom:1px solid #EEF2F7;">{!! nl2br(e($value)) !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </td></tr>
                @endif

                @if (! empty($note))
                <tr><td style="padding:10px 28px 4px;">
                    <div style="padding:12px 14px;border-radius:10px;background:#F1F5F9;color:#475569;font-size:13px;line-height:1.55;">{{ $note }}</div>
                </td></tr>
                @endif

                <tr><td style="padding:18px 28px 26px;font-size:13px;color:#64748B;">Cu drag,<br><strong style="color:#101827;">Echipa {{ $brand }}</strong></td></tr>
            </table>
        </td></tr>

        <tr><td style="padding:18px 8px;text-align:center;font-size:12px;line-height:1.6;color:#94A3B8;">
            <a href="{{ $site }}" style="color:#64748B;text-decoration:none;">{{ $brand }}</a> · înlocuire și reparații parbrize în toată țara<br>
            Ai primit acest mesaj în legătură cu o cerere trimisă prin {{ $brand }}.
        </td></tr>
    </table>
</td></tr>
</table>
</body>
</html>
