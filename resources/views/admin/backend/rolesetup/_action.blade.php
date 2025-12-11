<x-edit-button href="{{ route('edit.roles.permission', $role->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3">
    <i class="fa fa-edit"></i>
</x-edit-button>

<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('role.permission.delete', $role->id) }}" style="background-color: red">
    <i class="fa fa-trash"></i>
</x-delete-button>