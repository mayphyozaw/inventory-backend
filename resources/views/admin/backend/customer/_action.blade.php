@if(Auth::guard('web')->user()->can('edit_customer'))
<x-edit-button href="{{ route('customer.edit', $customer->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3">
    <i class="fa fa-edit"></i>
</x-edit-button>
@endif


@if(Auth::guard('web')->user()->can('delete_customer'))
<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('customer.destroy',$customer->id) }}" style="background-color: red">
    <i class="fa fa-trash"></i>
</x-delete-button>
@endif