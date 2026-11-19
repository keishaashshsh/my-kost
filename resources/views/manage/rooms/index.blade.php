<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Manajemen Kamar</h2></x-slot>
<div class="max-w-7xl mx-auto p-4"><x-flash />
<a href="{{ route('manage.rooms.create') }}" class="btn mb-4">+ Tambah Kamar</a>
<div class="card overflow-x-auto"><table class="w-full text-sm">
  <tr class="border-b"><th>No</th><th>Tipe</th><th>Harga</th><th>Fasilitas</th><th>Status</th><th>Aksi</th></tr>
  @foreach($rooms as $r)
  <tr class="border-b"><td>{{ $r->number }}</td><td>{{ $r->type }}</td><td>Rp {{ number_format($r->price, 0, ',', '.') }}</td><td>{{ $r->facilities }}</td>
    <td><span class="badge {{ $r->status === 'kosong' ? 'b-ok' : 'b-bad' }}">{{ $r->status }}</span></td>
    <td class="flex gap-2"><a href="{{ route('manage.rooms.edit', $r) }}" class="btn btn-gray">Edit</a>
      <form method="POST" action="{{ route('manage.rooms.destroy', $r) }}" onsubmit="return confirm('Hapus kamar?')">@csrf @method('DELETE')<button class="btn btn-red">Hapus</button></form></td></tr>
  @endforeach
</table></div></div>
</x-app-layout>
