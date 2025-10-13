<!DOCTYPE html>
<html lang="en" class="scroll-smooth" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Primary Meta Tags -->
    <title>🔍 ITS NU Pekalongan Lost & Found Hub | {{ $slot ?? 'Reuniting Students with Belongings' }}</title>
    <meta name="description" content="Official lost & found platform for ITS NU Pekalongan campuses. Report lost items or claim found belongings across all ITS NU Pekalongan locations in Indonesia.">
    <meta name="keywords" content="its nu pekalongan lost and found, campus lost items, indonesia student lost property, its nu pekalongan lost items, its nu pekalongan found items, report lost item its nu pekalongan">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Icons & Theme -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#4f46e5">

    <!-- Font Awesome with Preloading -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Vite Core Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Enhanced Social Metadata -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ITS NU Pekalongan Lost & Found Hub">
    <meta property="og:title" content="ITS NU Pekalongan Lost & Found Hub | Reuniting Students with Belongings">
    <meta property="og:description" content="Official platform for lost and found items across all ITS NU Pekalongan campuses in Indonesia">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/social-preview.jpg') }}">
    <meta property="og:image:alt" content="ITS NU Pekalongan Lost & Found Platform Interface">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@itsnupkl">
    <meta name="twitter:title" content="ITS NU Pekalongan Lost & Found Hub">
    <meta name="twitter:description" content="Find lost items or report found belongings across ITS NU Pekalongan campuses">
    <meta name="twitter:image" content="{{ asset('images/social-twitter-preview.jpg') }}">
    <meta name="twitter:image:alt" content="ITS NU Pekalongan Lost & Found Service">

    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://vite.example.com">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 font-sans antialiased">
