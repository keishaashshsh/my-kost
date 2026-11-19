<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Laporan Keuangan</h2></x-slot>
<div class="max-w-7xl mx-auto p-4 space-y-4">
  <div class="card"><canvas id="chart" height="90"></canvas></div>
  <div class="card overflow-x-auto"><h3 class="font-semibold mb-2">Tagihan Belum Lunas</h3><table class="w-full text-sm">
    <tr class="border-b"><th>Periode</th><th>Penghuni</th><th>Kamar</th><th>Total</th><th>Jatuh Tempo</th><th>Status</th></tr>
    @forelse($unpaid as $b)
    <tr class="border-b"><td>{{ $b->period }}</td><td>{{ $b->contract->user->name }}</td><td>{{ $b->contract->room->number }}</td>
      <td>Rp {{ number_format($b->total, 0, ',', '.') }}</td><td>{{ $b->due_date->format('d M Y') }}</td><td>{{ $b->status }}</td></tr>
    @empty<tr><td colspan="6">Tidak ada tunggakan.</td></tr>@endforelse
  </table></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chart'), {
  type: 'bar',
  data: {
    labels: @json($months),
    datasets: [
      { label: 'Pemasukan (lunas)', data: @json($income), backgroundColor: '#16a34a' },
      { label: 'Tunggakan', data: @json($arrears), backgroundColor: '#dc2626' }
    ]
  }
});
</script>
</x-app-layout>
