<div class="card">
  @if($room->photo)<img src="{{ asset('storage/'.$room->photo) }}" class="w-full h-40 object-cover rounded mb-2" alt="Kamar {{ $room->number }}">
  @else<div class="w-full h-40 bg-gray-200 rounded mb-2 flex items-center justify-center text-gray-500">Belum ada foto</div>@endif
  <div class="flex justify-between"><b>Kamar {{ $room->number }} · {{ $room->type }}</b>
    <span class="badge {{ $room->status === 'kosong' ? 'b-ok' : 'b-bad' }}">{{ $room->status }}</span></div>
  <div class="text-indigo-600 font-semibold">Rp {{ number_format($room->price, 0, ',', '.') }} / bulan</div>
  <div class="text-sm text-gray-600 mb-2">{{ $room->facilities }}</div>
  <a href="{{ route('rooms.show', $room) }}" class="btn">Lihat Detail</a>
</div>
