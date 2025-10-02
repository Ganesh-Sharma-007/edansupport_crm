
<form action="{{ route('service-users.update', $serviceUser) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" value="{{ old('contact_number', $serviceUser->contact_number) }}" class="form-control form-control-sm">
        </div>
        <div class="col-md-6">
            <label class="form-label">Fax</label>
            <input type="text" name="fax" value="{{ old('fax', $serviceUser->fax) }}" class="form-control form-control-sm">
        </div>
        <div class="col-md-6">
            <label class="form-label">Other</label>
            <input type="text" name="other" value="{{ old('other', $serviceUser->other) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 d-grid">
            <button class="btn btn-primary btn-sm">Save Contact</button>
        </div>
    </div>
</form>