@extends('admin.admin_main')
@section('title', 'Edit Permission')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Permission</h4>
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
                            <form class="row g-3" action="{{ route('permission.update',$permission->id) }}" method="post" id="submit-form">
                                @csrf
                                 @method('PUT')
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label"> Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$permission->name}}">
                                </div>


                                 <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Permission Group</label>
                                    <select class="form-select" name="group_name" id="example-select">
                                        <option value="" selected>Select Group</option>
                                        <option value="Brand" {{ $permission->group_name === 'Brand' ? 'selected' : '' }}> Brand </option>
                                        <option value="WareHouse" {{ $permission->group_name === 'WareHouse' ? 'selected' : '' }}> WareHouse </option>
                                        <option value="Supplier" {{ $permission->group_name === 'Supplier' ? 'selected' : '' }}> Supplier </option>
                                        <option value="Customer" {{ $permission->group_name === 'Customer' ? 'selected' : '' }}> Customer </option>
                                        <option value="Product" {{ $permission->group_name === 'Product' ? 'selected' : '' }}> Product </option>
                                        <option value="Purchase" {{ $permission->group_name === 'Purchase' ? 'selected' : '' }}> Purchase </option>
                                        <option value="Sale" {{ $permission->group_name === 'Sale' ? 'selected' : '' }}> Sale </option>
                                        <option value="Due" {{ $permission->group_name === 'Due' ? 'selected' : '' }}> Due </option>
                                        <option value="Transfer" {{ $permission->group_name === 'Transfer' ? 'selected' : '' }}> Transfer </option>
                                        <option value="Report" {{ $permission->group_name === 'Report' ? 'selected' : '' }}> Report </option>
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
        {!! JsValidator::formRequest('App\Http\Requests\Permission\PermissionUpdateRequest', '#submit-form') !!}
    @endpush
@endsection
