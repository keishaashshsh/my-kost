@extends('layouts.public')
@section('content')
<div class="text-center py-10">
  <h1 class="text-4xl font-bold text-indigo-700">My Kost</h1>
  <p class="mt-3 text-gray-600">Cari kamar kos yang nyaman, lihat harga dan fasilitas terbaru, lalu pesan langsung online.</p>
  <a href="{{ route('catalog') }}" class="btn mt-5">Lihat Semua Kamar</a>
</div>
<h2 class="text-xl font-semibold mb-3">Kamar Tersedia</h2>
<div class="grid md:grid-cols-3 gap-4">
  @forelse($rooms as $room) @include('public._card') @empty <p>Belum ada kamar kosong.</p> @endforelse
</div>
@endsection
