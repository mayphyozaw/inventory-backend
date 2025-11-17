@extends('admin.admin_main')
@section('title', 'All Reports')
@section('admin')
    <div class="page-content m-2">
        <div class="container">
           @include('admin.backend.report.body.report_top')
        </div>
        <div class="card">
            <nav class="navbar navbar-expand-lg bg-dark">
                <div class="container-fluid">
                     @include('admin.backend.report.body.report_menu')
                </div>
            </nav>

            <div class="card-body">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper db-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example" class="table table-stripe table-bordered dataTable" 
                                style="width:100%;" role="grid" aria-describedby="example_info">
                                    <thead>
                                        <tr role="row">
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Supplier</th>
                                            <th>Warehouse</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Status</th>
                                            <th>Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($returnSales as $key=>$saleReport)
                                            @foreach ($saleReport->saleReturnItems as $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$saleReport->date}}</td>
                                                <td>{{$saleReport->customer->name ?? ''}}</td>
                                                <td>{{$saleReport->warehouse->name ?? ''}}</td>
                                                <td>{{$item->product->name ?? ''}}</td>
                                                <td>{{$item->quantity ?? ''}}</td>
                                                <td>{{$item->net_unit_cost ?? ''}}</td>
                                                <td>{{$saleReport->status ?? ''}}</td>
                                                <td>{{$saleReport->grand_total ?? ''}}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection