@extends('admin.admin_main')
@section('title', 'Create Brand')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Brand</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Brand</a></li>
                        <li class="breadcrumb-item active">Add Brand</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Brand</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data" id="submit-form">
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Brad name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault02" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="image" id="brand_image">
                                </div>

                                <div class="col-md-6">
                                    <label for="validationDefault02" class="form-label"></label>
                                    <img id="showImage"
                                        src="{{ !empty($brandData->image) ? url('upload/brand_images/' . $brandData->image) : url('upload/no_image.jpg') }}"
                                        class="rounded-circle avatar-xl img-thumbnail float-start" alt="image profile">
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('#brand_image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            })
        })
    </script>
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\Brand\BrandStoreRequest', '#submit-form') !!}
    @endpush
@endsection
