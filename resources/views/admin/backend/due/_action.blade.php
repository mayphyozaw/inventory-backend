{{-- @if(Auth::guard('web')->user()->can('edit_sale_due')) --}}
<x-edit-button href="{{ route('sale.edit', $sale->id) }}" class="btn btn-info btn-sm" title="Pay Now">
    Pay Now
</x-edit-button>
{{-- @endif --}}


