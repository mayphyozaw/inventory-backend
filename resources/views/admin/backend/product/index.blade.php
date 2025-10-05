@extends('admin.admin_main')
@section('title', 'Product')
@section('admin')
    <div class="content">

        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">

                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">All Products Tables</li>
                    </ol>

                </div>

                <div class="text-end">
                    <x-create-button href="{{ route('product.create') }}">
                        Create Product
                    </x-create-button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Products</h5>
                        </div>

                        <div class="card-body">
                            <table id="datatable"
                                class="table productTable table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-start">#</th>
                                        <th class="text-start">Image</th>
                                        <th class="text-start">Name</th>
                                        <th class="text-start">Warehouse</th>
                                        <th class="text-start">Price</th>
                                        <th class="text-start">In Stock</th>
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
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('.productTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('product-datatable') }}",
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
                        data: 'image',
                        name: 'image',
                        className: 'text-start'
                    },

                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-start'
                    },

                    {
                        data: 'warehouse',
                        name: 'warehouse',
                        className: 'text-start',
                        orderable: false,
                        searchable: true
                    },

                    {
                        data: 'price',
                        name: 'price',
                        className: 'text-start'
                    },

                    {
                        data: 'stock_alert',
                        name: 'stock_alert',
                        className: 'text-start',
                        orderable: false,
                        searchable: false
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
