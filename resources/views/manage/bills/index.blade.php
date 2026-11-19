<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Tagihan & Pembayaran</h2></x-slot>
<div class="max-w-7xl mx-auto p-4"><x-flash />
<form method="POST" action="{{ route('manage.bills.generate') }}" class="mb-4">@csrf<button class="btn">Buat Tagihan Bulan Ini</button></form>
<div class="card overflow-x-auto"><table class="w-full text-sm">
  <tr class="border-b"><th>Periode</th><th>Penghuni</th><th>Kamar</th><th>Listrik</th><th>Air</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
  @forelse($bills as $b)
  <tr class="border-b align-top">
    <td>{{ $b->period }}</td><td>{{ $b->contract->user->name }}</td><td>{{ $b->contract->room->number }}</td>
    <td>{{ $b->elec_kwh }} kWh</td><td>{{ $b->water_m3 }} m³</td>
    <td><b>Rp {{ number_format($b->total, 0, ',', '.') }}</b></td>
    <td><span class="badge {{ $b->status === 'lunas' ? 'b-ok' : ($b->status === 'menunggu' ? 'b-wait' : 'b-bad') }}">{{ $b->status }}</span></td>
    <td>
      @if($b->status === 'belum')
        <form method="POST" action="{{ route('manage.bills.meter', $b) }}" class="flex gap-1">@csrf
          <input name="elec_kwh" type="number" min="0" value="{{ $b->elec_kwh }}" class="inp" style="width:5rem" title="kWh listrik">
          <input name="water_m3" type="number" min="0" value="{{ $b->water_m3 }}" class="inp" style="width:5rem" title="m3 air">
          <button class="btn">Hitung</button></form>
      @elseif($b->status === 'menunggu')
        <a href="{{ asset('storage/'.$b->proof) }}" target="_blank" class="text-indigo-600">Lihat bukti</a>
        <div class="flex gap-2 mt-1">
          <form method="POST" action="{{ route('manage.bills.verify', $b) }}">@csrf<button class="btn">Verifikasi</button></form>
          <form method="POST" action="{{ route('manage.bills.reject', $b) }}">@csrf<button class="btn btn-red">Tolak</button></form></div>
      @else
        <a href="{{ route('bills.receipt', $b) }}" class="btn btn-gray">Kuitansi</a>
      @endif
    </td>
  </tr>
  @empty<tr><td colspan="8">Belum ada tagihan. Klik "Buat Tagihan Bulan Ini".</td></tr>@endforelse
</table></div>
<div class="mt-3">{{ $bills->links() }}</div></div>
</x-app-layout>
