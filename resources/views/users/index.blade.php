@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h5>Users</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">Add User</button>
    </div>

    <div class="table-responsive">
        <table class="table table-sm align-middle w-100" id="usersTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- Off-canvas create --}}
    <x-offcanvas id="offcanvasAddUser" title="Add User">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('users._form')
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
            </div>
        </form>
    </x-offcanvas>


    {{-- Off-canvas edit --}}
    <x-offcanvas id="offcanvasEditUser" title="Edit User">
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div id="editUserFormBody">
                <!-- AJAX loaded form fields -->
            </div>
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
            </div>
        </form>
    </x-offcanvas>

@endsection

@push('scripts')
    <script>

        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        $(document).on("click", ".btn-edit", function() {
            let userId = $(this).data("id");
            let url = $(this).data("url");

            $.get(url, function(res) {
                // assuming users/edit.blade.php returns the form HTML (_form.blade.php)
                $("#editUserFormBody").html(res.form);
                $("#editUserForm").attr("action", res.update_url);

                let offcanvas = new bootstrap.Offcanvas(document.getElementById("offcanvasEditUser"));
                offcanvas.show();
            });
        });
    </script>
@endpush
