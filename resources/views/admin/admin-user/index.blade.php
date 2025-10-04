@extends('admin.admin_main')
@section('title', 'Admin User Profile')
@section('admin')
    <div class="content">
        <div class="container">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <x-create-button href="{{ route('admin-user.create') }}">
                        
                        Create Admin User
                    </x-create-button>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="#">Admin Users</a></li>
                        <li class="breadcrumb-item active">All Admin Users Tables</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">All Admin Users</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" 
                                class="table table-bordered dt-responsive table-responsive nowrap" >
                                <thead>
                                    <tr>

                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profileData as $key => $item)
                                        <tr @if ($item->id === $currentUser->id) class="table-success fw-bold" @endif>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>
                                            <td>
                                                <img src="{{ $item->photo ? asset('upload/user_images/' . $item->photo) : asset('upload/user_images/default.png') }}"
                                                    alt="User Image" width="50">
                                            </td>

                                            <td>
                                                <form action="{{ route('admin-user.destroy', $item->id) }}" method="POST"
                                                    class="deleteForm d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admin-user.edit', $item->id) }}"
                                                        class="btn  btn-sm" style="background-color: #1da0a3;"> <i class="fa fa-edit" style="color:#fafafa"></i></a>
                                                    @if ($item->id != $currentUser->id)
                                                    <button type="button"
                                                        class="btn  btn-sm deleteBtn" style="background-color: red">
                                                        <i class="fa fa-trash" style="color:#fafafa"></i>
                                                    </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '.deleteBtn', function(event) {
                event.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete thie Data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // ✅ actually submit the delete form
                    }
                });
            })
        })
    </script>
@endpush
