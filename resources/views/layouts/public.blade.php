<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Kost</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @include('partials.styles')
</head>
<body class="bg-gray-100 text-gray-800">
  <nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center text-sm">
      <a href="{{ route('home') }}" class="font-bold text-indigo-600 text-xl">My Kost</a>
      <div class="space-x-4">
        <a href="{{ route('catalog') }}">Katalog Kamar</a>
        @auth
          <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}" class="btn">Daftar</a>
        @endauth
      </div>
    </div>
  </nav>
  <main class="max-w-6xl mx-auto px-4 py-8"><x-flash />@yield('content')</main>
</body>
</html>
