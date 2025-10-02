@extends('layouts.app')

@section('title','Settings')

@section('content')
<ul class="nav nav-tabs mb-3" id="settingsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general-pane">General</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#holiday-pane">Holidays</button>
    </li>
</ul>

<div class="tab-content" id="settingsTabContent">
    <div class="tab-pane fade show active" id="general-pane" role="tabpanel">
        @include('settings.general')
    </div>
    <div class="tab-pane fade" id="holiday-pane" role="tabpanel">
        @include('settings.holiday')
    </div>
</div>
@endsection