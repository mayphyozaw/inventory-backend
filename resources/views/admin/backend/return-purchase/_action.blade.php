<x-edit-button href="{{ route('return-purchase.show', $returnPurchase->id) }}" class="btn btn-warning btn-sm" title="Details">
    <i class="fa fa-eye"></i>
</x-edit-button>

<x-edit-button href="{{ route('invoice.return-purchase', $returnPurchase->id) }}" class="btn btn-primary btn-sm" title="PDF Invocie">
    <i class="fa-solid fa-download"></i>
</x-edit-button>


<x-edit-button href="{{ route('return-purchase.edit', $returnPurchase->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3" title="Edit">
    <i class="fa fa-edit"></i>
</x-edit-button>



<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('return-purchase.destroy',$returnPurchase->id) }}" style="background-color: red" title="Delete">
    <i class="fa fa-trash-can"></i>
</x-delete-button>