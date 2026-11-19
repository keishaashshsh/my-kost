<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Tagihan Saya</h2></x-slot>
<div class="max-w-7xl mx-auto p-4"><x-flash />
<div class="card overflow-x-auto"><table class="w-full text-sm">
  <tr class="border-b"><th>Periode</th><th>Sewa</th><th>Listrik</th><th>Air</th><th>Total</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi</th></tr>
  @forelse($bills as $b)
  <tr class="border-b align-top">
    <td>{{ $b->period }}</td>
    <td>Rp {{ number_format($b->rent, 0, ',', '.') }}</td>
    <td>{{ $b->elec_kwh }} kWh</td><td>{{ $b->water_m3 }} m³</td>
    <td><b>Rp {{ number_format($b->total, 0, ',', '.') }}</b></td>
    <td>{{ $b->due_date->format('d M Y') }}</td>
    <td><span class="badge {{ $b->status === 'lunas' ? 'b-ok' : ($b->status === 'menunggu' ? 'b-wait' : 'b-bad') }}">{{ $b->status }}</span></td>
    <td>
      @if($b->status === 'lunas')
        <a class="btn" href="{{ route('bills.receipt', $b) }}">Unduh Kuitansi</a>
      @elseif($b->status === 'menunggu')
        Menunggu verifikasi
      @else
        <form method="POST" action="{{ route('bills.proof', $b) }}" enctype="multipart/form-data" class="flex gap-1">@csrf
          <input type="file" name="proof" accept="image/*" required class="text-xs"><button class="btn">Kirim</button></form>
      @endif
    </td>
  </tr>
  @empty<tr><td colspan="8">Belum ada tagihan.</td></tr>@endforelse
</table></div></div>
</x-app-layout>
