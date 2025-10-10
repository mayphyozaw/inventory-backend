{{-- <x-edit-button href="{{ route('product.show', $product->id) }}" class="btn btn-warning btn-sm" title="Details">
    <i class="fa fa-eye"></i>
</x-edit-button> --}}


<x-edit-button href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3" title="Edit">
    <i class="fa fa-edit"></i>
</x-edit-button>



<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('purchase.destroy',$purchase->id) }}" style="background-color: red" title="Delete">
    <i class="fa fa-trash"></i>
</x-delete-button>