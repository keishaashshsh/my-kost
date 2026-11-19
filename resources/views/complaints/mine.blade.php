<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Keluhan Saya</h2></x-slot>
<div class="max-w-7xl mx-auto p-4 grid md:grid-cols-3 gap-4"><div class="md:col-span-3"><x-flash /></div>
  <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="card space-y-2 h-fit">@csrf
    <h3 class="font-semibold">Kirim Keluhan</h3>
    <input name="title" class="inp" placeholder="Judul (mis. AC rusak)" required>
    <textarea name="body" class="inp" rows="4" placeholder="Jelaskan masalahnya" required></textarea>
    <input type="file" name="photo" accept="image/*" class="text-sm">
    <button class="btn">Kirim</button>
  </form>
  <div class="md:col-span-2 space-y-3">
    @forelse($complaints as $c)
    <div class="card"><div class="flex justify-between"><b>{{ $c->title }}</b>
      <span class="badge {{ $c->status === 'selesai' ? 'b-ok' : ($c->status === 'diproses' ? 'b-wait' : '') }}">{{ $c->status }}</span></div>
      <p class="text-sm my-1">{{ $c->body }}</p>
      @if($c->photo)<img src="{{ asset('storage/'.$c->photo) }}" class="h-24 rounded">@endif
      <div class="text-xs text-gray-500">{{ $c->created_at->format('d M Y H:i') }}</div></div>
    @empty<div class="card">Belum ada keluhan.</div>@endforelse
  </div>
</div>
</x-app-layout>
