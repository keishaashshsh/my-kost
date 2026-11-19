@extends('layouts.public')
@section('content')
<div class="grid md:grid-cols-2 gap-6">
  <div class="card">
    @if($room->photo)<img src="{{ asset('storage/'.$room->photo) }}" class="w-full rounded" alt="Kamar {{ $room->number }}">
    @else<div class="h-60 bg-gray-200 rounded flex items-center justify-center text-gray-500">Belum ada foto</div>@endif
  </div>
  <div class="card">
    <h1 class="text-2xl font-bold">Kamar {{ $room->number }} · {{ $room->type }}</h1>
    <div class="text-indigo-600 text-xl font-semibold my-2">Rp {{ number_format($room->price, 0, ',', '.') }} / bulan</div>
    <p class="mb-3">{{ $room->description }}</p>
    <b>Fasilitas</b>
    <ul class="list-disc ml-5 mb-4">@foreach($room->facilityList() as $f)<li>{{ $f }}</li>@endforeach</ul>

    @if($room->status !== 'kosong')
      <span class="badge b-bad">Kamar sudah terisi</span>
    @elseif(auth()->guest())
      <a href="{{ route('login') }}" class="btn">Login untuk memesan</a>
    @elseif(auth()->user()->role === 'penghuni')
      <form method="POST" action="{{ route('booking.store', $room) }}" class="space-y-2">@csrf
        <label class="text-sm">Tanggal mulai tinggal</label>
        <input type="date" name="start_date" class="inp" required>
        <textarea name="note" class="inp" placeholder="Catatan (opsional)"></textarea>
        <button class="btn">Booking Kamar</button>
      </form>
    @endif
  </div>
</div>
@endsection
