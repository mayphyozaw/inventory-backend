{{-- <style>
    .subtable,
    td,
    th {
        border: 1px solid;
    }

    .subtable {
        width: 100%;
        border-collapse: collapse;
    }
</style>
<p>
    <a class="btn btn-secondary btn-sm" data-bs-toggle="collapse" href="#collapseExample_{{ $transfer->id }}" role="button"
        aria-expanded="false" aria-controls="collapseExample_{{ $transfer->id }}">
        View Items
    </a>
</p>

<div class="collapse" id="collapseExample_{{ $transfer->id }}">
    <table class="subtable">
        <thead>
            <tr style="background-color: #e1f1f2">
                <th class="text-center">
                    Product
                </th>
                <th class="text-center">
                    Stock Transfer Qty
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = [];
            @endphp
            @foreach ($transfer->transferItems as $item)
                <tr>
                    <td class="text-right">
                        {{ $item->product->name ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $item->quantity ?? '0' }}
                        @php
                            $total[] += $item->quantity ?? 0;
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" style="background-color:rgb(234, 237, 234)">
                    Total
                </td>
                <td class="text-center" style="background-color:rgb(234, 237, 234)">
                    @php
                        echo array_sum($total);
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
</div> --}}

@foreach ($transfer->transferItems as $item)
    <div>
        {{ $item->product->name ?? '' }}
    </div>
@endforeach