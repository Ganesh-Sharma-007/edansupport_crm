@extends('layouts.app')

@section('title','Add Employee')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Add Employee</h5>
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<x-offcanvas id="offcanvasAddEmployee" title="Add Employee">
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('employees._form')
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Add</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</x-offcanvas>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Offcanvas(document.getElementById('offcanvasAddEmployee')).show();
    });
</script>
@endsection