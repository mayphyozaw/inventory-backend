@extends('admin.admin_main')
@section('title', 'Update Supplier')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Update Supplier </h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
                        <li class="breadcrumb-item active">Add Supplier</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Supplier</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('supplier.update', $supplier->id) }}" method="post" enctype="multipart/form-data" id="submit-form">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $supplier->name }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Supplier Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $supplier->email }}">
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Supplier Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}">
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Supplier Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $supplier->address }}">
                                </div>
                                
                                

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>


    
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\Supplier\SupplierUpdateRequest', '#submit-form') !!}
    @endpush
@endsection
