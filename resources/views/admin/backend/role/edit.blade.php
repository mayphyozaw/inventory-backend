@extends('admin.admin_main')
@section('title', 'Edit Role')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Role</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                        <li class="breadcrumb-item active">Add Role</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Role</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('role.update',$role->id) }}" method="post" id="submit-form">
                                @csrf
                                 @method('PUT')
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label"> Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$role->name}}">
                                </div>

                                <h5 class="card-title mb-0 py-3">Permissions</h5>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-3 col-6">
                                            <div class="mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        id="checkbox_{{$permission->id}}" value="{{$permission->name}}" 
                                                        @if (in_array($permission->id, $old_permissions))
                                                            checked
                                                        @endif>
                                                    <label class="form-check-label" for="checkbox_{{$permission->id}}">
                                                       {{$permission->name}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
        {!! JsValidator::formRequest('App\Http\Requests\Role\RoleUpdateRequest', '#submit-form') !!}
    @endpush
@endsection
