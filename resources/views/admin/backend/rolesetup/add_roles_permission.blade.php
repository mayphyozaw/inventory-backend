@extends('admin.admin_main')
@section('title', 'Create Roles in Permission')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Role in Permission</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Role In Permission</a></li>
                        <li class="breadcrumb-item active">Add Role In Permission</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Role In Permission</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('role.permission.store') }}" method="post" id="submit-form">
                                @csrf


                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Role Name</label>
                                    <select class="form-select" name="role_id" id="example-select">
                                        <option value="" selected>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Permission All
                                    </label>
                                </div>
                                <hr>
                                @foreach ($permission_groups as $group => $permissions)
                                {{-- @foreach ($permission_groups as $group) --}}
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{ $group}}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-9">
                                            {{-- @php
                                            $permissions = App\Models\User::getpermissionGroupByName($group->group_name);
                                            @endphp --}}

                                            @foreach ($permissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" name="permission[]" type="checkbox"
                                                        value="{{ $permission->id }}" id="checkbox_{{ $permission->id }}">
                                                    <label class="form-check-label" for="checkbox_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    </div>
                                @endforeach
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
