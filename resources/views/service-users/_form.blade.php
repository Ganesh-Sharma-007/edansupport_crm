<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Type</label>
        <input type="text" name="type" value="{{ old('type', $serviceUser->type ?? '') }}" class="form-control form-control-sm" placeholder="e.g. Elderly">
    </div>
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <select name="title" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="Mr"   @selected(old('title', $serviceUser->title ?? '') == 'Mr')>Mr</option>
            <option value="Mrs"  @selected(old('title', $serviceUser->title ?? '') == 'Mrs')>Mrs</option>
            <option value="Miss" @selected(old('title', $serviceUser->title ?? '') == 'Miss')>Miss</option>
            <option value="Ms"   @selected(old('title', $serviceUser->title ?? '') == 'Ms')>Ms</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $serviceUser->first_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Middle Initial</label>
        <input type="text" name="middle_initial" value="{{ old('middle_initial', $serviceUser->middle_initial ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name', $serviceUser->last_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="{{ old('email', $serviceUser->email ?? '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Preferred Name</label>
        <input type="text" name="preferred_name" value="{{ old('preferred_name', $serviceUser->preferred_name ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($serviceUser) && $serviceUser->date_of_birth ? $serviceUser->date_of_birth->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="male"   @selected(old('gender', $serviceUser->gender ?? '') == 'male')>Male</option>
            <option value="female" @selected(old('gender', $serviceUser->gender ?? '') == 'female')>Female</option>
            <option value="other"  @selected(old('gender', $serviceUser->gender ?? '') == 'other')>Other</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Marital Status</label>
        <input type="text" name="marital_status" value="{{ old('marital_status', $serviceUser->marital_status ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Ethnic Origin</label>
        <input type="text" name="ethnic_origin" value="{{ old('ethnic_origin', $serviceUser->ethnic_origin ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Religion</label>
        <input type="text" name="religion" value="{{ old('religion', $serviceUser->religion ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $serviceUser->city ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $serviceUser->country ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Postcode</label>
        <input type="text" name="postcode" value="{{ old('postcode', $serviceUser->postcode ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($serviceUser) && $serviceUser->start_date ? $serviceUser->start_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Service Priority</label>
        <input type="text" name="service_priority" value="{{ old('service_priority', $serviceUser->service_priority ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $serviceUser->branch ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Care Hours</label>
        <input type="number" step="0.1" name="care_hours" value="{{ old('care_hours', $serviceUser->care_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Visit Duration</label>
        <input type="text" name="visit_duration" value="{{ old('visit_duration', $serviceUser->visit_duration ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Type of Service User</label>
        <input type="text" name="type_of_service_user" value="{{ old('type_of_service_user', $serviceUser->type_of_service_user ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" rows="2" class="form-control form-control-sm">{{ old('address', $serviceUser->address ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" value="{{ old('contact_number', $serviceUser->contact_number ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fax</label>
        <input type="text" name="fax" value="{{ old('fax', $serviceUser->fax ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Other</label>
        <input type="text" name="other" value="{{ old('other', $serviceUser->other ?? '') }}" class="form-control form-control-sm">
    </div>
</div>