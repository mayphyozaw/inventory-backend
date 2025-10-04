@extends('admin.admin_main')
@section('title', 'Create Customer')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Customer</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Customer</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data" id="submit-form">
                                @csrf
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label">Customer name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label"> Customer Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label"> Customer Phone</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                               <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Customer Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>


    
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerStoreRequest', '#submit-form') !!}
    @endpush
@endsection
