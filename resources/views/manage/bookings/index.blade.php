<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Booking Kamar</h2></x-slot>
<div class="max-w-7xl mx-auto p-4"><x-flash />
<div class="card overflow-x-auto"><table class="w-full text-sm">
  <tr class="border-b"><th>Calon Penghuni</th><th>Kamar</th><th>Mulai</th><th>Catatan</th><th>Status</th><th>Aksi</th></tr>
  @forelse($bookings as $b)
  <tr class="border-b"><td>{{ $b->user->name }}<br><span class="text-xs text-gray-500">{{ $b->user->email }}</span></td>
    <td>{{ $b->room->number }}</td><td>{{ $b->start_date->format('d M Y') }}</td><td>{{ $b->note }}</td>
    <td><span class="badge {{ $b->status === 'dikonfirmasi' ? 'b-ok' : ($b->status === 'ditolak' ? 'b-bad' : 'b-wait') }}">{{ $b->status }}</span></td>
    <td>@if($b->status === 'menunggu')<div class="flex gap-2">
      <form method="POST" action="{{ route('manage.bookings.confirm', $b) }}">@csrf<button class="btn">Konfirmasi</button></form>
      <form method="POST" action="{{ route('manage.bookings.reject', $b) }}">@csrf<button class="btn btn-red">Tolak</button></form></div>@endif</td></tr>
  @empty<tr><td colspan="6">Belum ada booking.</td></tr>@endforelse
</table></div></div>
</x-app-layout>
