@extends('layouts.app')

@section('title','Edit Roster')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Edit Roster Shift</h5>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<x-offcanvas id="offcanvasEditRoster" title="Edit Roster Shift" :placement="'end'">
    <form action="{{ route('rostering.update', $roster) }}" method="POST">
        @csrf @method('PUT')
        @include('rostering._form')
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</x-offcanvas>

<script>
window.addEventListener('DOMContentLoaded', () => {
    new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster')).show();
});
</script>
@endsection