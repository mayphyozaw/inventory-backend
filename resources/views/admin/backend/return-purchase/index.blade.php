@extends('admin.admin_main')
@section('title', 'All Return Purchases')
@section('admin')
    <div class="content">

        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">

                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Return Purchases</a></li>
                        <li class="breadcrumb-item active">All Return Purchases Tables</li>
                    </ol>

                </div>

                <div class="text-end">
                    <x-create-button href="{{ route('return-purchase.create') }}">
                        Create Return Purchase
                    </x-create-button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Return Purchases</h5>
                        </div>

                        <div class="card-body">
                            <table id="datatable"
                                class="table returnPurchaseTable table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-start">Sl</th>
                                        <th class="text-start">WareHouse</th>
                                        <th class="text-start">Status</th>
                                        <th class="text-start">Grand Total</th>
                                        <th class="text-start">Payment</th>
                                        <th class="text-start">Created On</th>
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
            var table = $('.returnPurchaseTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('return-purchase-datatable') }}",
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
                        data: 'warehouse',
                        name: 'warehouse',
                        className: 'text-start'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-start'
                    },

                    {
                        data: 'grand_total',
                        name: 'grand_total',
                        className: 'text-start',
                        orderable: false,
                        searchable: true
                    },

                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-start'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
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
