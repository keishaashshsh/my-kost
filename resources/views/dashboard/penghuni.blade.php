<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Dashboard Penghuni</h2></x-slot>
<div class="max-w-7xl mx-auto p-4 space-y-4"><x-flash />
  @if($contract)
  <div class="card">
    <h3 class="font-semibold mb-2">Kamar Saya</h3>
    <p>Kamar <b>{{ $contract->room->number }}</b> ({{ $contract->room->type }}) · Rp {{ number_format($contract->room->price, 0, ',', '.') }}/bulan</p>
    <p class="text-sm text-gray-600">Kontrak: {{ $contract->start_date->format('d M Y') }} s/d {{ $contract->end_date->format('d M Y') }}</p>
    <div class="flex gap-2 mt-3">
      <form method="POST" action="{{ route('contracts.extend', $contract) }}">@csrf<button class="btn">Perpanjang 6 Bulan</button></form>
      <form method="POST" action="{{ route('contracts.end', $contract) }}" onsubmit="return confirm('Akhiri kontrak?')">@csrf<button class="btn btn-red">Akhiri Kontrak</button></form>
    </div>
  </div>
  <div class="card">
    <h3 class="font-semibold mb-2">Status Pembayaran Terbaru</h3>
    <table class="w-full text-sm">
      @forelse($bills as $b)
      <tr class="border-b"><td>{{ $b->period }}</td><td>Rp {{ number_format($b->total, 0, ',', '.') }}</td>
        <td><span class="badge {{ $b->status === 'lunas' ? 'b-ok' : ($b->status === 'menunggu' ? 'b-wait' : 'b-bad') }}">{{ $b->status }}</span></td></tr>
      @empty<tr><td>Belum ada tagihan.</td></tr>@endforelse
    </table>
    <a href="{{ route('bills.mine') }}" class="text-indigo-600 text-sm">Lihat semua tagihan →</a>
  </div>
  @else
  <div class="card">Kamu belum punya kamar aktif. <a href="{{ route('catalog') }}" class="text-indigo-600">Cari kamar</a>.</div>
  @endif

  @if($bookings->count())
  <div class="card"><h3 class="font-semibold mb-2">Booking Saya</h3>
    <table class="w-full text-sm">@foreach($bookings as $bk)
      <tr class="border-b"><td>Kamar {{ $bk->room->number }}</td><td>Mulai {{ $bk->start_date->format('d M Y') }}</td>
      <td><span class="badge {{ $bk->status === 'dikonfirmasi' ? 'b-ok' : ($bk->status === 'ditolak' ? 'b-bad' : 'b-wait') }}">{{ $bk->status }}</span></td></tr>
    @endforeach</table></div>
  @endif

  <div class="card"><h3 class="font-semibold mb-2">Pengumuman</h3>
    @forelse($announcements as $a)<div class="border-b py-2"><b>{{ $a->title }}</b><p class="text-sm">{{ $a->body }}</p></div>@empty<p>Tidak ada pengumuman.</p>@endforelse
  </div>
</div>
</x-app-layout>
