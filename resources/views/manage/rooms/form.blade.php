@php $isNew = ! $room->exists; @endphp
<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">{{ $isNew ? 'Tambah' : 'Edit' }} Kamar</h2></x-slot>
<div class="max-w-2xl mx-auto p-4"><x-flash />
<form method="POST" enctype="multipart/form-data" class="card space-y-3"
  action="{{ $isNew ? route('manage.rooms.store') : route('manage.rooms.update', $room) }}">
  @csrf @if(! $isNew) @method('PUT') @endif
  <div><label class="text-sm">Nomor kamar</label><input name="number" class="inp" value="{{ old('number', $room->number) }}" required></div>
  <div><label class="text-sm">Tipe</label><input name="type" class="inp" value="{{ old('type', $room->type) }}" placeholder="Standar / Deluxe" required></div>
  <div><label class="text-sm">Harga per bulan (Rp)</label><input type="number" name="price" class="inp" value="{{ old('price', $room->price) }}" required></div>
  <div><label class="text-sm">Fasilitas (pisahkan dengan koma)</label><input name="facilities" class="inp" value="{{ old('facilities', $room->facilities) }}"></div>
  <div><label class="text-sm">Deskripsi</label><textarea name="description" class="inp" rows="3">{{ old('description', $room->description) }}</textarea></div>
  <div><label class="text-sm">Status</label>
    <select name="status" class="inp"><option value="kosong" @selected(old('status', $room->status) === 'kosong')>Kosong</option><option value="terisi" @selected(old('status', $room->status) === 'terisi')>Terisi</option></select></div>
  <div><label class="text-sm">Foto</label><input type="file" name="photo" accept="image/*" class="text-sm"></div>
  <button class="btn">Simpan</button> <a href="{{ route('manage.rooms.index') }}" class="btn btn-gray">Batal</a>
</form></div>
</x-app-layout>
