@if(Auth::guard('web')->user()->can('edit_category'))
<x-edit-button href="{{ route('category.edit', $category->id) }}" class="btn btn-info btn-sm" style="background-color:#1da0a3">
    <i class="fa fa-edit"></i>
</x-edit-button>
@endif

@if(Auth::guard('web')->user()->can('delete_category'))
<x-delete-button href="#" class="btn btn-danger btn-sm deleteBtn" data-url="{{ route('category.destroy',$category->id) }}" style="background-color: red">
    <i class="fa fa-trash"></i>
</x-delete-button>
@endif