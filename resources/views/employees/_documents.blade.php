<ul class="nav nav-pills mb-3" id="docTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#care-plan">Care Plan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#incident">Incident</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#daily-records">Daily Records</button>
    </li>
    <li class="nav-item ms-auto">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddDoc">Add Document</button>
    </li>
</ul>

<div class="tab-content" id="docPanes">
    <div class="tab-pane fade show active" id="care-plan">No documents yet.</div>
    <div class="tab-pane fade" id="incident">No documents yet.</div>
    <div class="tab-pane fade" id="daily-records">No documents yet.</div>
</div>

{{-- Add document modal --}}
<x-modal id="modalAddDoc" title="Add Document">
    <form id="formAddDoc" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Document Type</label>
            <select name="type" class="form-select" required>
                <option value="care-plan">Care Plan</option>
                <option value="incident">Incident</option>
                <option value="daily-records">Daily Records</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Upload</button>
        </div>
    </form>
</x-modal>