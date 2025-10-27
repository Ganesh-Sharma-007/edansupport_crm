<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Username *</label>
        <input type="text" name="username" value="{{ old('username', $employee->username ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Password @if(!isset($employee))*@endif</label>
        <input type="password" name="password" class="form-control form-control-sm" @if(!isset($employee)) required @endif>
        @isset($employee)<small class="text-muted">Leave blank to keep current</small>@endisset
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirm Password @if(!isset($employee))*@endif</label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" @if(!isset($employee)) required @endif>
    </div>

    <div class="col-md-4">
        <label class="form-label">Title</label>
        <select name="title" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="Mr"   @selected(old('title', $employee->title ?? '') == 'Mr')>Mr</option>
            <option value="Mrs"  @selected(old('title', $employee->title ?? '') == 'Mrs')>Mrs</option>
            <option value="Miss" @selected(old('title', $employee->title ?? '') == 'Miss')>Miss</option>
            <option value="Ms"   @selected(old('title', $employee->title ?? '') == 'Ms')>Ms</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Middle Initial</label>
        <input type="text" name="middle_initial" value="{{ old('middle_initial', $employee->middle_initial ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Preferred Name</label>
        <input type="text" name="preferred_name" value="{{ old('preferred_name', $employee->preferred_name ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($employee) && $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($employee) && $employee->start_date ? $employee->start_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Date of Termination</label>
        <input type="date" name="date_of_termination" value="{{ old('date_of_termination', isset($employee) && $employee->date_of_termination ? $employee->date_of_termination->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" rows="2" class="form-control form-control-sm">{{ old('address', $employee->address ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $employee->city ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Postcode</label>
        <input type="text" name="postcode" value="{{ old('postcode', $employee->postcode ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">House No</label>
        <input type="text" name="house_no" value="{{ old('house_no', $employee->house_no ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $employee->branch ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Area</label>
        <input type="text" name="area" value="{{ old('area', $employee->area ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Mobile No</label>
        <input type="text" name="mobile_no" value="{{ old('mobile_no', $employee->mobile_no ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Contracted Hours</label>
        <input type="number" step="0.1" name="contracted_hours" value="{{ old('contracted_hours', $employee->contracted_hours ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Tax Code</label>
        <input type="text" name="tax_code" value="{{ old('tax_code', $employee->tax_code ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="male"   @selected(old('gender', $employee->gender ?? '') == 'male')>Male</option>
            <option value="female" @selected(old('gender', $employee->gender ?? '') == 'female')>Female</option>
            <option value="other"  @selected(old('gender', $employee->gender ?? '') == 'other')>Other</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Marital Status</label>
        <input type="text" name="marital_status" value="{{ old('marital_status', $employee->marital_status ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Nationality</label>
        <input type="text" name="nationality" value="{{ old('nationality', $employee->nationality ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Ethnic Origin</label>
        <input type="text" name="ethnic_origin" value="{{ old('ethnic_origin', $employee->ethnic_origin ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Religion</label>
        <input type="text" name="religion" value="{{ old('religion', $employee->religion ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">National Insurance</label>
        <input type="text" name="national_insurance" value="{{ old('national_insurance', $employee->national_insurance ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Days per Week</label>
        <input type="number" min="0" max="7" name="days_per_week" value="{{ old('days_per_week', $employee->days_per_week ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Hours of Week</label>
        <input type="number" step="0.1" name="hours_of_week" value="{{ old('hours_of_week', $employee->hours_of_week ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Drive / Non-Driver</label>
        <select name="drive_status" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="driver"      @selected(old('drive_status', $employee->drive_status ?? '') == 'driver')>Driver</option>
            <option value="non-driver"  @selected(old('drive_status', $employee->drive_status ?? '') == 'non-driver')>Non-Driver</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estimate Hour Pay Date</label>
        <input type="date" name="estimate_hour_pay_date" value="{{ old('estimate_hour_pay_date', isset($employee) && $employee->estimate_hour_pay_date ? $employee->estimate_hour_pay_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">DBS in Place</label>
        <input type="text" name="dbs_in_place" value="{{ old('dbs_in_place', $employee->dbs_in_place ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label class="form-label">Medical Issue</label>
        <textarea name="medical_issue" rows="2" class="form-control form-control-sm">{{ old('medical_issue', $employee->medical_issue ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Next of Kin Name</label>
        <input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name', $employee->next_of_kin_name ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="disability" value="1" @checked(old('disability', $employee->disability ?? false))>
            <label class="form-check-label">Disability</label>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Home Address</label>
        <textarea name="home_address" rows="2" class="form-control form-control-sm">{{ old('home_address', $employee->home_address ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Emergency Contact No</label>
        <input type="text" name="emergency_contact_no" value="{{ old('emergency_contact_no', $employee->emergency_contact_no ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Emergency Contact Email</label>
        <input type="email" name="emergency_contact_email" value="{{ old('emergency_contact_email', $employee->emergency_contact_email ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Consent Status</label>
        <input type="text" name="consent_status" value="{{ old('consent_status', $employee->consent_status ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Consent Date</label>
        <input type="date" name="consent_date" value="{{ old('consent_date', isset($employee) && $employee->consent_date ? $employee->consent_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12 d-flex gap-2">
        {{-- <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_salaried" value="1" @checked(old('is_salaried', $employee->is_salaried ?? false))>
            <label class="form-check-label">Is Salaried?</label>
        </div> --}}
        <div class="form-check">
    <input type="hidden" name="is_salaried" value="0">

    <input 
        class="form-check-input" 
        type="checkbox" 
        name="is_salaried" 
        value="1" 
        @checked(old('is_salaried', $employee->is_salaried ?? false))
    >
    <label class="form-check-label">Is Salaried?</label>
</div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="enforce_hours" value="1" @checked(old('enforce_hours', $employee->enforce_hours ?? false))>
            <label class="form-check-label">Enforce Hours?</label>
        </div>
    </div>
</div>