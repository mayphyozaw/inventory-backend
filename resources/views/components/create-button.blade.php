{{-- <div class="d-flex flex-wrap gap-2">
<a href="{{route('brand.create')}}" class="btn btn-outline-primary ml-10">{{$slot}}</a>
</div> --}}

<a {{ $attributes->merge(['class' => 'btn btn-secondary  ml-10']) }}  >
    {{ $slot }}
</a>