@php
$siteName = config('app.name', 'Nova Priča');
$pageTitle = trim($__env->yieldContent('title'));
$fullTitle = $pageTitle ? $pageTitle . ' | ' . $siteName : $siteName . ' – Gastro pub | Mostar';
$description = trim($__env->yieldContent('meta_description'))
?: 'Nova Priča, Mostar – vikend događaji, live muzika i rezervacija stolova online. Pogledajte nadolazeće događaje i rezervišite svoj stol.';
$ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/naslovna.jpg');
// Canonical bez query parametara, uvijek na glavnom hostu iz APP_URL.
$canonical = rtrim(config('app.url'), '/') . '/' . ltrim(request()->path(), '/');
$canonical = rtrim($canonical, '/') ?: config('app.url');
@endphp
<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 160) }}">
<link rel="canonical" href="{{ $canonical }}">
@hasSection('noindex')
<meta name="robots" content="noindex, nofollow">
@endif

<meta property="og:type" content="{{ trim($__env->yieldContent('og_type')) ?: 'website' }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 200) }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="bs_BA">
<meta name="twitter:card" content="summary_large_image">

<link rel="icon" type="image/png" href="{{ asset('images/NovaPrica.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/NovaPrica.png') }}">

@stack('structured_data')