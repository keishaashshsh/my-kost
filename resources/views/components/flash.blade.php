@if(session('ok'))<div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('ok') }}</div>@endif
@if(session('err'))<div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('err') }}</div>@endif
@if($errors->any())<div class="bg-red-100 text-red-800 p-3 rounded mb-4">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
