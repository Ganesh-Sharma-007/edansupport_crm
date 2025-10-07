@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <x-card title="All Notifications">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Details</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    
                    {{-- @forelse($logs as $log)
                <tr>
                    <td>{{ $log->title }}</td>
                    <td>{{ $log->body }}</td>
                    <td>{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <x-empty-table colspan="3" />
                @endforelse --}}



                    @forelse($logs as $log)
                        <tr>
                            <td>{{ ucfirst($log->type) }} {{ ucfirst($log->entity) }}</td>
                            <td>{{ $log->message }}</td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <x-empty-table colspan="3" />
                    @endforelse

                </tbody>
            </table>
        </div>
        {{-- {{ $logs->links() }} --}}
        {{ $logs->links('pagination::bootstrap-5') }}

    </x-card>
@endsection
