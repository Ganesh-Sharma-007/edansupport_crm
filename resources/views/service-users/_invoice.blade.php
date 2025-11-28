{{-- <form action="{{ route('service-users.update', $serviceUser) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Funder Type</label>
            <select name="funder_type" class="form-select form-select-sm">
                <option value="">--</option>
                <option value="private" @selected(old('funder_type', $serviceUser->funder_type ?? '') == 'private')>Private</option>
                <option value="public"  @selected(old('funder_type', $serviceUser->funder_type ?? '') == 'public')>Public</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Funder</label>
            <select name="funder_id" class="form-select form-select-sm">
                <option value="">--</option>
                @foreach(\App\Models\Funder::where('is_active', true)->get() as $f)
                <option value="{{ $f->id }}" @selected(old('funder_id', $serviceUser->funder_id ?? '') == $f->id)>{{ $f->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Care Price (£)</label>
            <input type="number" step="0.01" name="care_price" value="{{ old('care_price', $serviceUser->care_price ?? '') }}" class="form-control form-control-sm">
        </div>
        <div class="col-md-6">
            <label class="form-label">Travel Time (min)</label>
            <input type="number" name="travel_time" value="{{ old('travel_time', $serviceUser->travel_time ?? '') }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 d-grid">
            <button class="btn btn-primary btn-sm">Save Invoice Settings</button>
        </div>
    </div>
</form> --}}



<form action="{{ route('service-users.update', $serviceUser) }}" method="POST">
    @csrf @method('PUT')

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Funder Type</label>
            <select name="funder_type" class="form-select form-select-sm">
                <option value="">--</option>
                <option value="private" @selected(old('funder_type', $serviceUser->funder_type) == 'private')>Private</option>
                <option value="public" @selected(old('funder_type', $serviceUser->funder_type) == 'public')>Public</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Funder</label>
            <select name="funder_id" class="form-select form-select-sm">
                <option value="">--</option>
                @foreach(\App\Models\Funder::where('is_active', true)->get() as $f)
                    <option value="{{ $f->id }}" @selected(old('funder_id', $serviceUser->funder_id) == $f->id)>{{ $f->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Care Price (£)</label>
            <input type="number" step="0.01" name="care_price" value="{{ old('care_price', $serviceUser->care_price) }}" class="form-control form-control-sm">
        </div>

        <div class="col-md-6">
            <label class="form-label">Travel Time (min)</label>
            <input type="number" name="travel_time" value="{{ old('travel_time', $serviceUser->travel_time) }}" class="form-control form-control-sm">
        </div>

        <div class="col-12 d-grid">
            <button class="btn btn-primary btn-sm">Save Invoice Settings</button>
        </div>
    </div>
</form>