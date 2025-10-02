<ul class="nav nav-pills mb-3">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#care-plan-pane">Care Plan</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#risk-pane">Risk Assessment</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#policy-pane">Policy & Procedure</button></li>
    <li class="nav-item ms-auto">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalSuDoc">Add Document</button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="care-plan-pane">No care-plan documents yet.</div>
    <div class="tab-pane fade" id="risk-pane">No risk assessments yet.</div>
    <div class="tab-pane fade" id="policy-pane">No policy documents yet.</div>
</div>

{{-- Upload modal --}}
<x-modal id="modalSuDoc" title="Add Document">
    <form id="formSuDoc" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Document Type</label>
            <select name="type" class="form-select" required>
                <option value="care-plan">Care Plan</option>
                <option value="risk-assessment">Risk Assessment</option>
                <option value="policy-procedure">Policy & Procedure</option>
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