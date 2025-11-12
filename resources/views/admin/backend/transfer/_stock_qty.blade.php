@foreach ($transfer->transferItems as $item)
<span class="badge bg-primary me-1">
    {{$item->quantity ?? '0'}}
</span>
@endforeach