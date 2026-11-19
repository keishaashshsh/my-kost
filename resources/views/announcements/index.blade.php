<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Pengumuman</h2></x-slot>
<div class="max-w-4xl mx-auto p-4 space-y-4"><x-flash />
  @if(auth()->user()->role === 'owner')
  <form method="POST" action="{{ route('manage.announcements.store') }}" class="card space-y-2">@csrf
    <h3 class="font-semibold">Buat Pengumuman</h3>
    <input name="title" class="inp" placeholder="Judul" required>
    <textarea name="body" class="inp" rows="3" placeholder="Isi pengumuman" required></textarea>
    <button class="btn">Terbitkan</button>
  </form>
  @endif
  @forelse($announcements as $a)
  <div class="card"><div class="flex justify-between"><b>{{ $a->title }}</b><span class="text-xs text-gray-500">{{ $a->created_at->format('d M Y') }}</span></div>
    <p class="text-sm mt-1">{{ $a->body }}</p>
    @if(auth()->user()->role === 'owner')
    <form method="POST" action="{{ route('manage.announcements.destroy', $a) }}" class="mt-2">@csrf @method('DELETE')<button class="text-red-600 text-sm">Hapus</button></form>@endif
  </div>
  @empty<div class="card">Belum ada pengumuman.</div>@endforelse
</div>
</x-app-layout>
