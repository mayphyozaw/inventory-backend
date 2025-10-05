@extends('admin.admin_main')
@section('title', 'Create Product')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-0">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Create Product</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <a href="{{ route('customer.index') }}" class="btn btn-dark">Back</a>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data"
                            id="submit-form">
                            @csrf
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Name:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter Name" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Code:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="code"
                                                placeholder="Enter Code" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-group w-100">
                                                <label for="" class="form-label">
                                                    Product Category:
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="category_id" id="category_id"
                                                    class="form-control form-select">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}">{{ $item->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-group w-100">
                                                <label class="form-label">
                                                    Brand:
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="brand_id" id="brand_id" class="form-control form-select">
                                                    <option value="">Select Brand</option>
                                                    @foreach ($brands as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Product Price:
                                            </label>
                                            <input type="text" class="form-control" name="price"
                                                placeholder="Enter Product Price" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Stock Alert:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" name="stock_alert"
                                                placeholder="Enter Stock Alert" min="0" required>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Notes:
                                            </label>
                                            <textarea class="form-control" name="note" rows="3" placeholder="Enter Notes"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label">
                                        Multiple Image:
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="mb-3">
                                        <input name="images[]" accept=".png, .jpg, .jpeg" multiple="" type="file"
                                            id="multiImg" class="upload-input-file form-control" />
                                    </div>

                                    <div class="row">
                                        <div id="preview_img"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-12 mb-3">
                                            <h4 class="text-center">Add Stock :</h4>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">
                                                    Warehouse:
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="warehouse_id" id="warehouse_id"
                                                    class="form-control form-select">
                                                    <option value="">Select WareHouse</option>
                                                    @foreach ($warehouses as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">
                                                    Supplier:
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="supplier_id" id="supplier_id"
                                                    class="form-control form-select">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">
                                                Product Quantity:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" name="product_qty"
                                                placeholder="Enter Product Quantity" min="1" required>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">Status : <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="status" class="form-control form-select">
                                                    <option selected="">Select Status</option>
                                                    <option value="Received">Received</option>
                                                    <option value="Pending" selected>Pending</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-xl-12">
                                    <div class="d-flex mt-5 justify-content-start">
                                        <button class="btn btn-primary me-3" type="submit">Save</button>
                                        <a class="btn btn-secondary" href="{{ route('product.index') }}">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('scripts')
    <script>
        document.getElementById("multiImg").addEventListener("change", function(event) {
            const previewContainer = document.getElementById("preview_img");
            previewContainer.innerHTML = ""; // Clear previous previews

            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);


                // Create preview container
                const col = document.createElement("div");
                col.className = "col-md-3 mb-3";

                // Create wrapper
                const wrapper = document.createElement("div");
                wrapper.style.position = "relative";
                wrapper.style.display = "inline-block";
                wrapper.style.margin = "5px";

                // Create image
                const img = document.createElement("img");
                img.src = url;
                img.width = 70;
                img.style.borderRadius = "8px";
                img.style.objectFit = "cover";
                img.className = "img-fluid rounded";
                img.style.maxHeight = "150px";
                img.alt = "Image Preview";



                // Create remove button
                const removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.className = "btn btn-danger btn-sm";
                removeBtn.innerHTML = "&times;";
                removeBtn.title = "Remove Image";

                // Button position styling
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "5px";
                removeBtn.style.right = "5px";
                removeBtn.style.padding = "0 6px";
                removeBtn.style.borderRadius = "50%";
                removeBtn.style.lineHeight = "1";

                // Remove preview when clicked
                removeBtn.addEventListener("click", function() {
                    wrapper.remove();
                });

                // Append elements
                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);


            }
        });
    </script>

    {!! JsValidator::formRequest('App\Http\Requests\Product\ProductStoreRequest', '#submit-form') !!}
@endpush
