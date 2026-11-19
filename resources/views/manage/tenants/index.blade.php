<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Penghuni & Kontrak</h2></x-slot>
<div class="max-w-7xl mx-auto p-4 space-y-4"><x-flash />
<form method="POST" action="{{ route('manage.tenants.store') }}" class="card grid md:grid-cols-5 gap-2 items-end">@csrf
  <div><label class="text-xs">Penghuni</label><select name="user_id" class="inp" required>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
  <div><label class="text-xs">Kamar (kosong)</label><select name="room_id" class="inp" required>@foreach($rooms as $r)<option value="{{ $r->id }}">{{ $r->number }}</option>@endforeach</select></div>
  <div><label class="text-xs">Mulai</label><input type="date" name="start_date" class="inp" required></div>
  <div><label class="text-xs">Selesai</label><input type="date" name="end_date" class="inp" required></div>
  <button class="btn">Catat Kontrak</button>
</form>
<div class="card overflow-x-auto"><table class="w-full text-sm">
  <tr class="border-b"><th>Penghuni</th><th>Kamar</th><th>Mulai</th><th>Selesai</th><th>Sisa</th><th>Status</th></tr>
  @forelse($contracts as $c)
  <tr class="border-b"><td>{{ $c->user->name }}</td><td>{{ $c->room->number }}</td><td>{{ $c->start_date->format('d M Y') }}</td><td>{{ $c->end_date->format('d M Y') }}</td>
    <td>@if($c->status === 'aktif'){{ max(0, (int) now()->diffInDays($c->end_date, false)) }} hari @else - @endif</td>
    <td><span class="badge {{ $c->status === 'aktif' ? 'b-ok' : '' }}">{{ $c->status }}</span></td></tr>
  @empty<tr><td colspan="6">Belum ada kontrak.</td></tr>@endforelse
</table></div></div>
</x-app-layout>
