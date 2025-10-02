<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name *</label>
        <input type="text" name="name" value="{{ old('name', $funder->name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Middle Initial</label>
        <input type="text" name="middle_initial" value="{{ old('middle_initial', $funder->middle_initial ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name', $funder->last_name ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Preferred Name</label>
        <input type="text" name="preferred_name" value="{{ old('preferred_name', $funder->preferred_name ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Type</label>
        <select name="type" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="Private" @selected(old('type', $funder->type ?? '') == 'Private')>Private</option>
            <option value="Public"  @selected(old('type', $funder->type ?? '') == 'Public')>Public</option>
            <option value="NHS"     @selected(old('type', $funder->type ?? '') == 'NHS')>NHS</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($funder) && $funder->start_date ? $funder->start_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" rows="2" class="form-control form-control-sm">{{ old('address', $funder->address ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">City / Town</label>
        <input type="text" name="city_town" value="{{ old('city_town', $funder->city_town ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $funder->country ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Postcode</label>
        <input type="text" name="postcode" value="{{ old('postcode', $funder->postcode ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $funder->branch ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" value="{{ old('mobile', $funder->mobile ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $funder->email ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Website</label>
        <input type="url" name="website" value="{{ old('website', $funder->website ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Fax</label>
        <input type="text" name="fax" value="{{ old('fax', $funder->fax ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Other</label>
        <input type="text" name="other" value="{{ old('other', $funder->other ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="2" class="form-control form-control-sm">{{ old('notes', $funder->notes ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="purchase_order_required" value="1" @checked(old('purchase_order_required', $funder->purchase_order_required ?? false))>
            <label class="form-check-label">Purchase Order No. Required?</label>
        </div>
    </div>
</div>