<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Profile Picture</label>
        <input type="file" name="avatar" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Username *</label>
        <input type="text" name="username" value="{{ old('username', $user->name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Password @if(!isset($user))*@endif</label>
        <input type="password" name="password" class="form-control form-control-sm" @if(!isset($user)) required @endif>
        @isset($user)<small class="text-muted">Leave blank to keep current</small>@endisset
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirm Password @if(!isset($user))*@endif</label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" @if(!isset($user)) required @endif>
    </div>

    <div class="col-md-4">
        <label class="form-label">Title</label>
        <select name="title" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="Mr"   @selected(old('title', $user->title ?? '') == 'Mr')>Mr</option>
            <option value="Mrs"  @selected(old('title', $user->title ?? '') == 'Mrs')>Mrs</option>
            <option value="Miss" @selected(old('title', $user->title ?? '') == 'Miss')>Miss</option>
            <option value="Ms"   @selected(old('title', $user->title ?? '') == 'Ms')>Ms</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select form-select-sm">
            <option value="">--</option>
            <option value="male"   @selected(old('gender', $user->gender ?? '') == 'male')>Male</option>
            <option value="female" @selected(old('gender', $user->gender ?? '') == 'female')>Female</option>
            <option value="other"  @selected(old('gender', $user->gender ?? '') == 'other')>Other</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Support Worker Type *</label>
        <select name="support_worker_type" class="form-select form-select-sm" required>
            <option value="">--</option>
            <option value="branch administrator" @selected(old('support_worker_type', $user->support_worker_type ?? '') == 'branch administrator')>Branch Administrator</option>
            <option value="employee" @selected(old('support_worker_type', $user->support_worker_type ?? '') == 'employee')>Employee</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Address Line 1</label>
        <input type="text" name="address_line_1" value="{{ old('address_line_1', $user->address_line_1 ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-12">
        <label class="form-label">Address Line 2</label>
        <input type="text" name="address_line_2" value="{{ old('address_line_2', $user->address_line_2 ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $user->city ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Postcode</label>
        <input type="text" name="postcode" value="{{ old('postcode', $user->postcode ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-4">
        <label class="form-label">Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $user->branch ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Latitude</label>
        <input type="number" step="any" name="latitude" value="{{ old('latitude', $user->latitude ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Longitude</label>
        <input type="number" step="any" name="longitude" value="{{ old('longitude', $user->longitude ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">PIN</label>
        <input type="text" name="pin" value="{{ old('pin', $user->pin ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Team</label>
        <input type="text" name="team" value="{{ old('team', $user->team ?? '') }}" class="form-control form-control-sm">
    </div>

    <div class="col-12 d-flex gap-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_shared" value="1" @checked(old('is_shared', $user->is_shared ?? false))>
            <label class="form-check-label">Is Shared?</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true))>
            <label class="form-check-label">Is Active?</label>
        </div>
    </div>
</div>