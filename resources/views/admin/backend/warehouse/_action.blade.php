<x-edit-button href="{{ route('warehouse.edit', $warehouse->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3">
    <i class="fa fa-edit"></i>
</x-edit-button>

<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('warehouse.destroy',$warehouse->id) }}" style="background-color: red">
    <i class="fa fa-trash"></i>
</x-delete-button>