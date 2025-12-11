@extends('admin.admin_main')
@section('title', 'Create Permission')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Permission</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
                        <li class="breadcrumb-item active">Add Permission</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Permission</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('permission.store') }}" method="post" id="submit-form">
                                @csrf
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label"> Permission Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Permission Group</label>
                                    <select class="form-select" name="group_name" id="example-select">
                                        <option value="" selected>Select Group</option>
                                        <option value="Brand"> Brand </option>
                                        <option value="WareHouse"> WareHouse </option>
                                        <option value="Supplier"> Supplier </option>
                                        <option value="Customer"> Customer </option>
                                        <option value="Product"> Product </option>
                                        <option value="Purchase"> Purchase </option>
                                        <option value="PurchaseReturn"> Purchase Return </option>
                                        <option value="Sale"> Sale </option>
                                        <option value="SaleReturn"> Sale Return </option>
                                        <option value="Due"> Due </option>
                                        <option value="Transfer"> Transfer </option>
                                        <option value="Report"> Report </option>
                                        <option value="Role"> Roles</option>
                                        <option value="Permission"> Permission</option>
                                        <option value="RolesInPermission"> Roles In Permission</option>
                                        <option value="ManageAdmin"> Manage Admin</option>

                                    </select>
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
        {!! JsValidator::formRequest('App\Http\Requests\Permission\PermissionStoreRequest', '#submit-form') !!}
    @endpush
@endsection
