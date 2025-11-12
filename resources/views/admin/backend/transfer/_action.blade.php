<x-edit-button href="{{ route('transfer.show', $transfer->id) }}" class="btn btn-warning btn-sm" title="Details">
    <i class="fa fa-eye"></i>
</x-edit-button>

<x-edit-button href="{{ route('transfer.edit', $transfer->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3" title="Edit">
    <i class="fa fa-edit"></i>
</x-edit-button>

<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('transfer.destroy',$transfer->id) }}" style="background-color: red" title="Delete">
    <i class="fa fa-trash-can"></i>
</x-delete-button>