<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown" style="width: 280px;">
    <li>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="px-3 py-2">
            @csrf @method('PUT')
            <div class="mb-2 text-center">
                <img id="profileAvatarImg" src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/user-placeholder.png') }}"
                     alt="Avatar" class="rounded-circle mb-2" height="80" width="80"><br>
                <input type="file" name="avatar" class="form-control form-control-sm" onchange="document.getElementById('profileAvatarImg').src = window.URL.createObjectURL(this.files[0])">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Phone</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control form-control-sm">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-sm">Update</button>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </form>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </li>
</ul>