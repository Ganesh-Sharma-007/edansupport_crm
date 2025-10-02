<ul class="nav nav-pills mb-3" id="healthTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#allergies">Allergies</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#medicine">Medicine</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#immunisation">Immunisation</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#conditions">Health Conditions</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#results">Test Results</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#consultations">Consultations</button>
    </li>
</ul>

<div class="tab-content" id="healthPanes">
    @foreach(['allergies','medicine','immunisation','conditions','results','consultations'] as $tab)
    <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $tab }}">
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ ucfirst($tab) }}</h6>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalHealth{{ $tab }}">Add Record</button>
        </div>
        <p class="text-muted">No records yet.</p>
    </div>
    @endforeach
</div>

{{-- Modals for each health tab --}}
@foreach(['allergies','medicine','immunisation','conditions','results','consultations'] as $tab)
<x-modal id="modalHealth{{ $tab }}" title="Add {{ ucfirst($tab) }} Record">
    <form class="health-upload" data-type="{{ $tab }}">
        <div class="mb-3">
            <label class="form-label">Summary</label>
            <textarea name="summary" rows="2" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Attachment (optional)</label>
            <input type="file" name="file" class="form-control">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Add</button>
        </div>
    </form>
</x-modal>
@endforeach