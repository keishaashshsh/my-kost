<!DOCTYPE html>
<html><head><meta charset="utf-8"><style>
body{font-family:DejaVu Sans,sans-serif;font-size:13px}
h2{text-align:center;margin-bottom:0}.c{text-align:center;color:#555;margin-top:2px}
table{width:100%;border-collapse:collapse;margin-top:15px}td{padding:6px;border-bottom:1px solid #ddd}
.t td{font-weight:bold;border-top:2px solid #000}
</style></head><body>
<h2>KUITANSI PEMBAYARAN</h2><p class="c">My Kost · No. {{ $bill->receipt_no }}</p>
<table>
<tr><td width="35%">Diterima dari</td><td>{{ $bill->contract->user->name }}</td></tr>
<tr><td>Kamar</td><td>{{ $bill->contract->room->number }} ({{ $bill->contract->room->type }})</td></tr>
<tr><td>Periode</td><td>{{ $bill->period }}</td></tr>
<tr><td>Sewa kamar</td><td>Rp {{ number_format($bill->rent, 0, ',', '.') }}</td></tr>
<tr><td>Listrik ({{ $bill->elec_kwh }} kWh)</td><td>Rp {{ number_format($bill->elec_kwh * config('mykost.tariff_kwh'), 0, ',', '.') }}</td></tr>
<tr><td>Air ({{ $bill->water_m3 }} m³)</td><td>Rp {{ number_format($bill->water_m3 * config('mykost.tariff_water'), 0, ',', '.') }}</td></tr>
<tr class="t"><td>TOTAL</td><td>Rp {{ number_format($bill->total, 0, ',', '.') }}</td></tr>
<tr><td>Tanggal lunas</td><td>{{ $bill->paid_at->format('d-m-Y H:i') }}</td></tr>
</table>
<p class="c" style="margin-top:30px">Pembayaran telah diverifikasi pemilik. Terima kasih.</p>
</body></html>
