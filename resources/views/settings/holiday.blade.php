<div class="d-flex justify-content-between mb-3">
    <h6>Holidays</h6>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddHoliday">Add Holiday</button>
</div>

<div class="table-responsive">
    <table class="table table-sm align-middle w-100" id="holidayTable">
        <thead class="table-light">
            <tr>
                <th>Holiday Name</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Holiday::orderBy('date')->get() as $h)
            <tr>
                <td>{{ $h->name }}</td>
                <td>{{ $h->date->format('d M Y') }}</td>
                <td>
                    <form action="{{ route('settings.holidays.destroy', $h) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <x-empty-table colspan="3" />
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add modal --}}
<x-modal id="modalAddHoliday" title="Add Holiday">
    <form action="{{ route('settings.holidays.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Holiday Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
</x-modal>