@if(Auth::guard('web')->user()->can('edit_permission'))
<x-edit-button href="{{ route('permission.edit', $permission->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3">
    <i class="fa fa-edit"></i>
</x-edit-button>
@endif

@if(Auth::guard('web')->user()->can('delete_permission'))
<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('permission.destroy',$permission->id) }}" style="background-color: red">
    <i class="fa fa-trash"></i>
</x-delete-button>
@endif