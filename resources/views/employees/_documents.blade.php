{{-- <ul class="nav nav-pills mb-3" id="docTabs" role="tablist">
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
</x-modal> --}}


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
    <div class="tab-pane fade show active" id="care-plan"></div>
    <div class="tab-pane fade" id="incident"></div>
    <div class="tab-pane fade" id="daily-records"></div>
</div>

<x-modal id="modalAddDoc" title="Add Document">
    <form id="formAddDoc" enctype="multipart/form-data">
        <input type="hidden" id="employee_id" value="{{ $employee->id }}">
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

{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const employeeId = document.getElementById('employee_id').value;
    const docForm = document.getElementById('formAddDoc');

    const loadDocuments = () => {
        fetch(`/employees/${employeeId}/documents`)
            .then(res => res.json())
            .then(data => {
                ['care-plan', 'incident', 'daily-records'].forEach(type => {
                    const pane = document.getElementById(type);
                    const docs = data[type] || [];
                    pane.innerHTML = docs.length
                        ? docs.map(d => `
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <a href="/storage/${d.file_path}" target="_blank">${d.file_name}</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteDoc(${d.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `).join('')
                        : '<div class="text-muted small">No documents yet.</div>';
                });
            });
    };

window.deleteDoc = (id) => {
    console.log("document id=======> ", id)
    console.log("employee id=======> ", employeeId)
    Swal.fire({
        title: 'Are you sure?',
        text: "This document will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/employees/${employeeId}/documents/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Document has been deleted successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
                loadDocuments();
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong while deleting the document.',
                });
            });
        }
    });
};


    docForm.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(docForm);
        fetch(`/employees/${employeeId}/documents`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(() => {
            docForm.reset();
            // ✅ Your requested addition
            toast('Document uploaded');
            bootstrap.Modal.getInstance(document.getElementById('modalAddDoc')).hide();
            loadDocuments();
        })
        .catch(() => toast('Something went wrong!', 'error'));
    });

    loadDocuments();
});
</script>
@endpush --}}

@push('scripts')

<script>
$(document).ready(function () {
    const employeeId = $('#employee_id').val();

    // 🔄 Load employee documents dynamically
    function loadDocuments() {
        $.get(`/employees/${employeeId}/documents`, function (data) {
            ['care-plan', 'incident', 'daily-records'].forEach(type => {
                const pane = $('#' + type);
                const docs = data[type] || [];
                if (docs.length) {
                    let html = '';
                    docs.forEach(d => {
                        html += `
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <a href="/storage/${d.file_path}" target="_blank">${d.file_name}</a>
                                <button class="btn btn-sm btn-danger btnDeleteDoc" data-id="${d.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>`;
                    });
                    pane.html(html);
                } else {
                    pane.html('<div class="text-muted small">No documents yet.</div>');
                }
            });
        });
    }

    // 📤 Upload document
    $('#formAddDoc').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: `/employees/${employeeId}/documents`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        success: function (res) {
            // ✅ Toast + Close Modal
            toast('Document uploaded successfully!');
            bootstrap.Modal.getInstance(document.getElementById('modalAddDoc')).hide();

            // Reload documents
            loadDocuments();
        },
            error: function (xhr) {
                let msg = 'Something went wrong while uploading the document.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: msg,
                });
            }
        });
    });
    // 🗑️ Delete Document via SweetAlert2 + AJAX
    $(document).on('click', '.btnDeleteDoc', function () {
        const docId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This document will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/employees/${employeeId}/documents/${docId}`,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Document has been deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadDocuments();
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong while deleting the document.',
                        });
                    }
                });
            }
        });
    });

    // 🚀 Initial load
    loadDocuments();
});
</script>
@endpush
