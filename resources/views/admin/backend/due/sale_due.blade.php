@extends('admin.admin_main')
@section('title', 'All Sales Due')
@section('admin')
    <div class="content">

        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">

                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sale Due</a></li>
                        <li class="breadcrumb-item active">All Sale Due Tables</li>
                    </ol>

                </div>

                <div class="text-end">

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Sale Due</h5>
                        </div>

                        <div class="card-body">
                            <table id="datatable"
                                class="table saleDueTable table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-start">Sl</th>
                                        <th class="text-start">WareHouse</th>
                                        <th class="text-start">Customer Name</th>
                                        <th class="text-start">Due Amount</th>
                                        <th class="text-start">Full Payment</th>

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
            var table = $('.saleDueTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('saleDue-datatable') }}",
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
                        data: 'customer',
                        name: 'customer',
                        className: 'text-start'
                    },

                    {
                        data: 'due_amount',
                        name: 'due_amount',
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

        });
    </script>
@endpush
