<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Start Date & Time *</label>
        <input type="datetime-local" name="start" value="{{ old('start', isset($roster) && $roster->start ? $roster->start->format('Y-m-d\TH:i') : '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">End Date & Time *</label>
        <input type="datetime-local" name="end" value="{{ old('end', isset($roster) && $roster->end ? $roster->end->format('Y-m-d\TH:i') : '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Shift Hours</label>
        <input type="number" step="0.1" name="shift_hours" value="{{ old('shift_hours', $roster->shift_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select form-select-sm" required>
            <option value="assigned"   @selected(old('status', $roster->status ?? '') == 'assigned')>Assigned</option>
            <option value="cancelled"  @selected(old('status', $roster->status ?? '') == 'cancelled')>Cancelled</option>
            <option value="complete"   @selected(old('status', $roster->status ?? '') == 'complete')>Complete</option>
            <option value="in-progress"@selected(old('status', $roster->status ?? '') == 'in-progress')>In-Progress</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Customer *</label>
        <select name="service_user_id" class="form-select form-select-sm" required>
            <option value="">--</option>
            @foreach(\App\Models\ServiceUser::where('is_active', true)->get() as $su)
            <option value="{{ $su->id }}" @selected(old('service_user_id', $roster->service_user_id ?? '') == $su->id)>{{ $su->first_name }} {{ $su->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Employee *</label>
        <select name="employee_id" class="form-select form-control-sm" required>
            <option value="">--</option>
            @foreach(\App\Models\Employee::where('is_active', true)->get() as $emp)
            <option value="{{ $emp->id }}" @selected(old('employee_id', $roster->employee_id ?? '') == $emp->id)>{{ $emp->first_name }} {{ $emp->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Travel Time (hours)</label>
        <input type="number" min="0" name="travel_hours" value="{{ old('travel_hours', $roster->travel_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Travel Time (minutes)</label>
        <input type="number" min="0" max="59" name="travel_minutes" value="{{ old('travel_minutes', $roster->travel_minutes ?? '') }}" class="form-control form-control-sm">
    </div>
</div>