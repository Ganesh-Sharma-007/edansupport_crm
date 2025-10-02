@extends('layouts.app')

@section('title','Edit User')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Edit User</h5>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<x-offcanvas id="offcanvasEditUser" title="Edit User" :placement="'end'">
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('users._form')
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</x-offcanvas>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Offcanvas(document.getElementById('offcanvasEditUser')).show();
    });
</script>
@endsection