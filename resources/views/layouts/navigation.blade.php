@include('partials.styles')
<nav class="bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center gap-4 text-sm">
    <a href="{{ route('home') }}" class="font-bold text-indigo-600 text-lg">My Kost</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    @if(auth()->user()->isStaff())
      <a href="{{ route('manage.rooms.index') }}">Kamar</a>
      <a href="{{ route('manage.bookings.index') }}">Booking</a>
      <a href="{{ route('manage.tenants.index') }}">Penghuni</a>
      <a href="{{ route('manage.bills.index') }}">Tagihan</a>
      <a href="{{ route('manage.complaints.index') }}">Keluhan</a>
      @if(auth()->user()->role === 'owner')<a href="{{ route('manage.reports.index') }}">Laporan</a>@endif
    @else
      <a href="{{ route('bills.mine') }}">Tagihan Saya</a>
      <a href="{{ route('complaints.mine') }}">Keluhan Saya</a>
    @endif
    <a href="{{ route('announcements.index') }}">Pengumuman</a>
    <div class="ml-auto flex gap-4 items-center">
      <a href="{{ route('profile.edit') }}">Profil ({{ auth()->user()->name }})</a>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-red-600">Keluar</button></form>
    </div>
  </div>
</nav>
