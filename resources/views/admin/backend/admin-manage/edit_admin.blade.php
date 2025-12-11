@extends('admin.admin_main')
@section('title', 'Edit Admin')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Admin</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('all.admin') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Edit Admin</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Admin</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                        
                            <form class="row g-3" action="{{ route('admin.update', $admin->id) }}" method="POST"  id="submit-form">
                                @csrf
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Admin name</label>
                                    <input type="text" class="form-control" name="name" value="{{$admin->name}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label"> Admin Email</label>
                                    <input type="email" class="form-control" name="email" value="{{$admin->email}}">
                                </div>
                                
                               <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label"> Roles Name </label>
                                    <select class="form-select" name="roles" id="example-select">
                                        <option value="" selected>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{$admin->hasRole($role->name) ? 'selected' : ''}}> {{ $role->name }} </option>
                                        @endforeach
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


    
    
@endsection
