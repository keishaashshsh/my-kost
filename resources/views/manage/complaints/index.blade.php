<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Penanganan Keluhan</h2></x-slot>
<div class="max-w-5xl mx-auto p-4 space-y-3"><x-flash />
  @forelse($complaints as $c)
  <div class="card"><div class="flex justify-between"><b>{{ $c->title }}</b><span class="text-xs text-gray-500">{{ $c->user->name }} · {{ $c->created_at->format('d M Y H:i') }}</span></div>
    <p class="text-sm my-1">{{ $c->body }}</p>
    @if($c->photo)<a href="{{ asset('storage/'.$c->photo) }}" target="_blank"><img src="{{ asset('storage/'.$c->photo) }}" class="h-24 rounded"></a>@endif
    <form method="POST" action="{{ route('manage.complaints.update', $c) }}" class="flex gap-2 mt-2 items-center">@csrf @method('PATCH')
      <select name="status" class="inp" style="width:10rem">@foreach(['diterima','diproses','selesai'] as $s)<option value="{{ $s }}" @selected($c->status === $s)>{{ ucfirst($s) }}</option>@endforeach</select>
      <button class="btn">Ubah Status</button></form>
  </div>
  @empty<div class="card">Belum ada keluhan.</div>@endforelse
</div>
</x-app-layout>
