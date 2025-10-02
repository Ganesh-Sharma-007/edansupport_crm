<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notiDropdown" style="width: 300px; max-height: 250px; overflow-y: auto;">
    <li><h6 class="dropdown-header">Recent Activities</h6></li>
    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $n)
        <li>
            <a class="dropdown-item small" href="{{ route('notifications.index') }}">
                <strong>{{ $n->title }}</strong><br>
                <span class="text-muted">{{ Str::limit($n->body, 50) }}</span><br>
                <small>{{ $n->created_at->diffForHumans() }}</small>
            </a>
        </li>
    @empty
        <li><span class="dropdown-item-text text-muted">No new notifications</span></li>
    @endforelse
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item small text-center" href="{{ route('notifications.index') }}">View all notifications</a></li>
</ul>