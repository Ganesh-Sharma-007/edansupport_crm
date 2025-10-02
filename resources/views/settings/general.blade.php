<div class="card shadow-sm">
    <div class="card-header">User Permissions</div>
    <div class="card-body">
        <table class="table table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPerms{{ $user->id }}">Edit</button>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Permission modals --}}
@foreach($users as $user)
<x-modal id="modalPerms{{ $user->id }}" title="Edit Permissions - {{ $user->name }}">
    <form action="{{ route('settings.permissions.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Allowed Routes</label>
            @php $perms = old('routes', $user->permissions ?? []); @endphp
            @foreach(['dashboard','users','employees','service-users','funders','rostering','timesheets','invoices','settings'] as $route)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="routes[]" value="{{ $route }}" @checked(in_array($route, $perms))>
                <label class="form-check-label">{{ ucfirst(str_replace('-', ' ', $route)) }}</label>
            </div>
            @endforeach
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
</x-modal>
@endforeach