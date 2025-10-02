@extends('layouts.app')

@section('title','Timesheets')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Timesheet Week {{ $start->format('d M Y') }}</h5>
    <div class="d-flex gap-2">
        <a href="{{ request()->fullUrlWithQuery(['week' => $start->copy()->subWeek()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">&laquo; Previous</a>
        <a href="{{ request()->fullUrlWithQuery(['week' => $start->copy()->addWeek()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">Next &raquo;</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm align-middle text-nowrap">
        <thead class="table-light">
            <tr>
                <th>Employee</th>
                <th>Total Hours</th>
                @foreach($days as $day)
                <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $emp)
            <tr>
                <td>{{ $emp->first_name }} {{ $emp->last_name }}</td>
                <td>{{ number_format($emp->rosters->sum('shift_hours'), 1) }}</td>
                @for($i = 0; $i < 7; $i++)
                @php
                    $day = $start->copy()->addDays($i);
                    $hours = $emp->rosters->filter(fn($r) => $r->start->isSameDay($day))->sum('shift_hours');
                @endphp
                <td>{{ $hours ?: '-' }}</td>
                @endfor
            </tr>
            @empty
            <x-empty-table colspan="9" />
            @endforelse
        </tbody>
    </table>
</div>
@endsection