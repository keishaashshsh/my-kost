@extends('layouts.public')
@section('content')
<h1 class="text-2xl font-bold mb-4">Katalog Kamar</h1>
<form method="GET" class="card grid md:grid-cols-4 gap-3 mb-6">
  <select name="type" class="inp"><option value="">Semua tipe</option>
    @foreach($types as $t)<option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>@endforeach</select>
  <input name="max_price" type="number" class="inp" placeholder="Harga maksimal" value="{{ request('max_price') }}">
  <input name="facility" class="inp" placeholder="Fasilitas (mis. AC)" value="{{ request('facility') }}">
  <button class="btn">Filter</button>
</form>
<div class="grid md:grid-cols-3 gap-4">
  @forelse($rooms as $room) @include('public._card') @empty <p>Tidak ada kamar yang cocok.</p> @endforelse
</div>
@endsection
