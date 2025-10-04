@extends('admin.admin_main')
@section('title', 'Supplier')
@section('admin')
    <div class="content">

        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Suppliers</a></li>
                        <li class="breadcrumb-item active">All Suppliers Tables</li>
                    </ol>
                </div>

                <div class="text-end">
                    <x-create-button href="{{ route('supplier.create') }}">
                        Create Supplier
                    </x-create-button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Suppliers</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable"
                                class="table supplierTable table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-start">#</th>
                                        <th class="text-start">Supplier Name</th>
                                        <th class="text-start">Email</th>
                                        <th class="text-start">Phone</th>
                                        <th class="text-start">Address</th>
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
            var table = $('.supplierTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('supplier-datatable') }}",
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
                        data: 'name',
                        name: 'name',
                        className: 'text-start'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-start'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-start'
                    },
                    {
                        data: 'address',
                        name: 'address',
                        className: 'text-start',
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
