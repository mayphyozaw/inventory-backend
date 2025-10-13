@extends('admin.admin_main')
@section('title', 'Detail Purchase')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-0">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0"> Purchase Details</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <a href="{{ route('purchase.index') }}" class="btn btn-dark">Back</a>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- supplier info --}}
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition:0.2s;">
                                    <div class="card-header text-white text-center"
                                        style="background:linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0px 0px;">
                                        <h5 class="mb-0 fw-bold">Supplier Information</h5>
                                    </div>
                                    <div class="card-body p-4">

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Name:</strong>
                                            <span>{{ $purchase->supplier->name ?? '' }}</span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Email:</strong>
                                            <span>{{ $purchase->supplier->email }}</span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Phone:</strong>
                                            <span>{{ $purchase->supplier->phone }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- supplier info --}}

                            {{-- Warehouse info --}}
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition:0.2s;">
                                    <div class="card-header text-white text-center"
                                        style="background:linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0px 0px;">
                                        <h5 class="mb-0 fw-bold">Company WareHouse Information</h5>
                                    </div>
                                    <div class="card-body p-4">

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Warehouse:</strong>
                                            <span>{{ $purchase->warehouse->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Warehouse info --}}


                            {{-- purchase info --}}
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition:0.2s;">
                                    <div class="card-header text-white text-center"
                                        style="background:linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0px 0px;">
                                        <h5 class="mb-0 fw-bold">Purchase Information</h5>
                                    </div>
                                    <div class="card-body p-4">

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Purchase Date:</strong>
                                            <span>{{ $purchase->date }}</span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Status:</strong>
                                            <span>{{ $purchase->status }}</span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Grand Total:</strong>
                                            <span>{{ number_format($purchase->grand_total, 2) }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- purchase info --}}

                            {{-- order summary --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card shadow-sm border-0 h-100"
                                            style="border-radius: 10px; transition:0.2s;">
                                            <div class="card-header text-white text-center"
                                                style="background:linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0px 0px;">
                                                <h5 class="mb-0 fw-bold">Order Summary</h5>
                                            </div>

                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Name</th>
                                                            <th>Quantity</th>
                                                            <th>Net Unit Cost</th>
                                                            <th>Discount</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($purchase->purchaseItems as $key=>$item)
                                                            <tr>
                                                            <td>{{$key + 1}}</td>
                                                            <td>{{$item->product->name}}</td>
                                                            <td>{{$item->quantity}}</td>
                                                            <td>{{number_format($item->net_unit_cost,2)}}</td>
                                                            <td>{{number_format($item->discount,2)}}</td>
                                                            <td>{{number_format($item->subtotal,2)}}</td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- order summary --}}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
