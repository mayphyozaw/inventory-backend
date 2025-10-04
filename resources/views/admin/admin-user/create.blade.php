@extends('admin.admin_main')
@section('title', 'Create Admin Users')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Profile</h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-pane pt-4" id="profile_setting" role="tabpanel">
                                <div class="row">

                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12">
                                            <div class="card border mb-0">

                                                <div class="card-header">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h4 class="card-title mb-0">Personal Information</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <form action="{{ route('admin-user.store') }}" method="post"
                                                        enctype="multipart/form-data" id="submit-form">
                                                        @csrf

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Name</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="text" name="name">

                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Email</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="email" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Password</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="password" name="password">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">Phone</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <input class="form-control" type="text" name="phone">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3 row">
                                                            <label class="form-label">
                                                                Address
                                                            </label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <textarea class="form-control" name="address"></textarea>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-6">
                                                            <label for="validationDefault02" class="form-label">Admin User
                                                                Image</label>
                                                            <input type="file" class="form-control" name="photo"
                                                                id="admin_user_image">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="validationDefault02" class="form-label"></label>
                                                            <img id="showImage"
                                                                src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                                                class="rounded-circle avatar-xl img-thumbnail float-start"
                                                                alt="image profile">
                                                        </div>

                                                        <div class="form-group ">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Save</button>

                                                            </div>
                                                        </div>

                                                    </form>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#admin_user_image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            })
        })
    </script>
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#submit-form') !!}
    @endpush
@endsection
