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
                                            <th>SI</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Warehouse</th>
                                            <th>Stock Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key=>$item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->name ?? ''}}</td>
                                                <td>{{$item->productCategory->category_name ?? ''}}</td>
                                                <td>{{$item->warehouse->name ?? ''}}</td>
                                                <td><h5><span class="badge text-bg-secondary">{{$item->product_qty ?? ''}}</span></h5></td>
                                            </tr>
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