@extends('admin.admin_main')
@section('title', 'Category')
@section('admin')
    <div class="content">

        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product Category</a></li>
                        <li class="breadcrumb-item active">All Category Tables</li>
                    </ol>
                </div>

                <div class="text-end">
                    <x-create-button href="{{ route('category.create') }}" data-bs-toggle="modal"
                        data-bs-target="#standard-modal">
                        Create Category
                    </x-create-button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Categories</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable"
                                class="table categoryTable table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-start">St</th>
                                        <th class="text-start">Category Name</th>
                                        <th class="text-start">Category Slug</th>
                                        <th class="text-start">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="standard-modalLabel">Product Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data"
                        id="submit-form">
                        @csrf
                        <div class="col-md-12">
                            <label for="validationDefault01" class="form-label">Category name</label>
                            <input type="text" class="form-control" name="category_name" required>
                        </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\Category\CategoryStoreRequest', '#submit-form') !!}
    <script>
        $(document).ready(function() {
            var table = $('.categoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('category-datatable') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-start',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        className: 'text-start'
                    },
                    {
                        data: 'category_slug',
                        name: 'category_slug',
                        className: 'text-start'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-start',
                        orderable: false,
                        searchable: false
                    }
                ],

                responsive: true
            });


            $(document).on('click', '.deleteBtn', function(event) {
                event.preventDefault();
                var url = $(this).data('url');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete thie Data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload();
                                toastr.success(response.message);
                            },
                            error: function(response) {
                                toastr.error('Delete failed!');
                            }

                        });
                    }
                });
            })
        });
    </script>
   
   
@endpush
