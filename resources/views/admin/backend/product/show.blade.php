@extends('admin.admin_main')
@section('title', 'Product Detail')
@section('admin')

    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">Product Detail</li>
                    </ol>
                </div>
                <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <a href="{{ route('product.index') }}" class="btn btn-dark">Back</a>
                        </ol>
                    </div>
            </div>
            <hr>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <h5 class="mb-3">Product Images</h5>
                            <div class="d-flex flex-wrap">
                                @forelse ($product->productImages as $image)
                                    <img src="{{ asset('upload/product_images/' . $image->image) }}" alt="image" class="me-2 mb-2" width="100"
                                        height="100" style="object-fit:cover; border:1px solid #ddd; border-radius:5px">

                                @empty
                                    <p class="text-danger">No Image Available</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-7">
                            <h5 class="mb-3">Product Information</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>Name:</strong>
                                    {{$product->name}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Code:</strong>
                                    {{$product->code}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Warehouse:</strong>
                                    {{$product->warehouse->name}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Supplier:</strong>
                                    {{$product->supplier->name}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Category:</strong>
                                    {{$product->productCategory->category_name}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Brand:</strong>
                                    {{$product->brand->name}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Price:</strong>
                                    {{$product->price}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Stock Alert:</strong>
                                    {{$product->stock_alert}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Product Qty:</strong>
                                    {{$product->product_qty}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Product Status:</strong>
                                    {{$product->status}}
                                </li>

                                <li class="list-group-item">
                                    <strong>Product Note:</strong>
                                    {{$product->note}}
                                </li>

                                <li class="list-group-item">
                                    <strong> Created On:</strong>
                                    {{\Carbon\Carbon::parse($product->createdt_at)->format('F Y')}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
