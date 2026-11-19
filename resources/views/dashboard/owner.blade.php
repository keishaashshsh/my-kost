<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Dashboard {{ auth()->user()->role === 'owner' ? 'Pemilik' : 'Admin' }}</h2></x-slot>
<div class="max-w-7xl mx-auto p-4"><x-flash />
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="card"><div class="text-sm text-gray-500">Okupansi</div><div class="text-2xl font-bold">{{ $occupied }} / {{ $totalRooms }} kamar</div></div>
    <div class="card"><div class="text-sm text-gray-500">Pemasukan bulan ini</div><div class="text-2xl font-bold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</div></div>
    <div class="card"><div class="text-sm text-gray-500">Tunggakan</div><div class="text-2xl font-bold text-red-600">Rp {{ number_format($arrears, 0, ',', '.') }}</div></div>
    <div class="card"><div class="text-sm text-gray-500">Perlu verifikasi</div><div class="text-2xl font-bold">{{ $toVerify }} pembayaran</div></div>
    <div class="card"><div class="text-sm text-gray-500">Booking menunggu</div><div class="text-2xl font-bold">{{ $pendingBooks }}</div></div>
    <div class="card"><div class="text-sm text-gray-500">Keluhan aktif</div><div class="text-2xl font-bold">{{ $openComplaints }}</div></div>
  </div>
</div>
</x-app-layout>
