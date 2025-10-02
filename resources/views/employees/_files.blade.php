<div class="d-flex justify-content-between mb-3">
    <h6>Folders</h6>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateFolder">Create Folder</button>
</div>

<div class="row" id="folderList">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-folder fs-1 text-warning"></i>
                <div class="small">General</div>
            </div>
        </div>
    </div>
</div>

{{-- Create folder modal --}}
<x-modal id="modalCreateFolder" title="Create Folder">
    <form id="formCreateFolder">
        <div class="mb-3">
            <label class="form-label">Folder Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Create</button>
        </div>
    </form>
</x-modal>