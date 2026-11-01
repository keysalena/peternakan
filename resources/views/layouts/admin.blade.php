<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') · TernakKu</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Hanken+Grotesk:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>
</head>
<body>
@include('partials.icons')
@include('partials.sidebar')

<main>
  @include('partials.topbar')
  @yield('content')
</main>

@include('partials.mobile-nav')
@stack('modals')
@include('partials.toast')

<form id="logout-form" method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" hidden>@csrf</form>

<script src="{{ asset('js/sidebar.js') }}" defer></script>
<script src="{{ asset('js/toast.js') }}" defer></script>
<script src="{{ asset('js/modal.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
