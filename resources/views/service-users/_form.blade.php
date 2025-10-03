<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Type</label>
        <input type="text" name="type" value="{{ old('type', $su->type ?? '') }}" class="form-control form-control-sm" placeholder="e.g. Elderly">
    </div>
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <select name="title" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="Mr"   @selected(old('title', $su->title ?? '') == 'Mr')>Mr</option>
            <option value="Mrs"  @selected(old('title', $su->title ?? '') == 'Mrs')>Mrs</option>
            <option value="Miss" @selected(old('title', $su->title ?? '') == 'Miss')>Miss</option>
            <option value="Ms"   @selected(old('title', $su->title ?? '') == 'Ms')>Ms</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $su->first_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Middle Initial</label>
        <input type="text" name="middle_initial" value="{{ old('middle_initial', $su->middle_initial ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name', $su->last_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="{{ old('email', $su->email ?? '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Preferred Name</label>
        <input type="text" name="preferred_name" value="{{ old('preferred_name', $su->preferred_name ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($su) && $su->date_of_birth ? $su->date_of_birth->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="male"   @selected(old('gender', $su->gender ?? '') == 'male')>Male</option>
            <option value="female" @selected(old('gender', $su->gender ?? '') == 'female')>Female</option>
            <option value="other"  @selected(old('gender', $su->gender ?? '') == 'other')>Other</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Marital Status</label>
        <input type="text" name="marital_status" value="{{ old('marital_status', $su->marital_status ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Ethnic Origin</label>
        <input type="text" name="ethnic_origin" value="{{ old('ethnic_origin', $su->ethnic_origin ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Religion</label>
        <input type="text" name="religion" value="{{ old('religion', $su->religion ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $su->city ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $su->country ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Postcode</label>
        <input type="text" name="postcode" value="{{ old('postcode', $su->postcode ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($su) && $su->start_date ? $su->start_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Service Priority</label>
        <input type="text" name="service_priority" value="{{ old('service_priority', $su->service_priority ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $su->branch ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Care Hours</label>
        <input type="number" step="0.1" name="care_hours" value="{{ old('care_hours', $su->care_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Visit Duration</label>
        <input type="text" name="visit_duration" value="{{ old('visit_duration', $su->visit_duration ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Type of Service User</label>
        <input type="text" name="type_of_service_user" value="{{ old('type_of_service_user', $su->type_of_service_user ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" rows="2" class="form-control form-control-sm">{{ old('address', $su->address ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" value="{{ old('contact_number', $su->contact_number ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fax</label>
        <input type="text" name="fax" value="{{ old('fax', $su->fax ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Other</label>
        <input type="text" name="other" value="{{ old('other', $su->other ?? '') }}" class="form-control form-control-sm">
    </div>
</div>