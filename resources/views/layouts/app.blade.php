<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <div id="app">
        @include('partials.navbar')
        <div class="container-fluid">
            <div class="row">
                @include('partials.sidebar')
                <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('title', 'Dashboard')</h1>
                    </div>
                    <x-alert type="success" :message="session('success')" />
                    {{-- <x-alert type="danger"  :message="session('error')" /> --}}

                    @php
                        $errorMessages = session('error');
                        if ($errors->any()) {
                            $errorMessages = '<ul class="mb-0">';
                            foreach ($errors->all() as $error) {
                                $errorMessages .= "<li>{$error}</li>";
                            }
                            $errorMessages .= '</ul>';
                        }
                    @endphp

                    @if ($errorMessages)
                        <x-alert type="danger" :message="$errorMessages" />
                    @endif


                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @include('partials.scripts')

    {{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: "{{ route('rostering.index', ['ajax' => true]) }}",

        // ✅ Limit visible events and show "+ more" link
        dayMaxEvents: 3,
        // dayMaxEventRows: true,

        eventDidMount: info => {
            new bootstrap.Tooltip(info.el, {
                title: info.event.extendedProps.tooltip,
                container: 'body'
            });
        },

        eventClick: info => showRosterDetails(info.event),
    });

    calendar.render();

    // ✅ View/Edit/Delete modal handler
    function showRosterDetails(event) {
        Swal.fire({
            title: 'Roster Details',
            html: `
                <strong>Task:</strong> ${event.title}<br>
                <strong>Status:</strong> <span class="badge bg-${event.extendedProps.badge}">
                    ${event.extendedProps.status}
                </span><br>
                <strong>Start:</strong> ${event.startStr}<br>
                <strong>End:</strong> ${event.endStr}<br><br>
                <div class="text-center mt-3">
                    <button id="editRosterBtn" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-edit me-1"></i> Edit
                    </button>
                    <button id="deleteRosterBtn" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash me-1"></i> Delete
                    </button>
                </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            didOpen: () => {
                const btnEdit = document.getElementById('editRosterBtn');
                const btnDelete = document.getElementById('deleteRosterBtn');

                if (btnEdit) {
                    btnEdit.addEventListener('click', () => openEditRoster(event.id));
                }

                if (btnDelete) {
                    btnDelete.addEventListener('click', () => {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This roster will be permanently deleted!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/rostering/${event.id}`, {
                                    method: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                        "Accept": "application/json",
                                    },
                                })
                                .then(response => {
                                    if (!response.ok) throw new Error("Failed to delete roster");
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire("Deleted!", data.message || "Roster deleted successfully.", "success");
                                    calendar.refetchEvents();
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    Swal.fire("Error!", "Something went wrong while deleting.", "error");
                                });
                            }
                        });
                    });
                }
            }
        });
    }

    // ✅ Edit form offcanvas loader
    function openEditRoster(id) {
        Swal.close();
        fetch(`/rostering/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('editRosterFormBody').innerHTML = data.form;
                document.getElementById('editRosterForm').action = data.update_url;
                new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster')).show();
            })
            .catch(() => Swal.fire('Error', 'Failed to load edit form.', 'error'));
    }
});
</script>
@endpush --}}

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const calendarEl = document.getElementById('calendar');

                if (!calendarEl) return;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    themeSystem: 'bootstrap5',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    events: "{{ route('rostering.index', ['ajax' => true]) }}",

                    // ✅ Limit visible events and show "+ more" link
                    dayMaxEvents: 3,

                    eventDidMount: info => {
                        new bootstrap.Tooltip(info.el, {
                            title: info.event.extendedProps.tooltip,
                            container: 'body'
                        });
                    },

                    eventClick: info => {
                        const event = info.event;
                        const props = event.extendedProps;

                        // ✅ Check event type (roster or holiday)
                        if (props.type === 'holiday') {
                            // 🎉 Holiday popup
                            Swal.fire({
                                title: `<strong>Public Holiday</strong>`,
                                html: `
                        <div class="text-start">
                            <p><b>Name:</b> ${event.title}</p>
                            <p><b>Date:</b> ${event.start.toLocaleDateString()}</p>
                        </div>
                    `,
                                icon: 'success',
                                confirmButtonText: 'Close',
                                confirmButtonColor: '#198754',
                            });
                        } else {
                            // 🧾 Roster popup
                            showRosterDetails(event);
                        }
                    },
                });

                calendar.render();

                // ✅ View/Edit/Delete modal handler
                function showRosterDetails(event) {
                    Swal.fire({
                        title: 'Roster Details',
                        html: `
                <strong>Task:</strong> ${event.title}<br>
                <strong>Status:</strong> <span class="badge bg-${event.extendedProps.badge}">
                    ${event.extendedProps.status}
                </span><br>
                <strong>Start:</strong> ${event.startStr}<br>
                <strong>End:</strong> ${event.endStr || 'N/A'}<br><br>
                <div class="text-center mt-3">
                    <button id="editRosterBtn" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-edit me-1"></i> Edit
                    </button>
                    <button id="deleteRosterBtn" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash me-1"></i> Delete
                    </button>
                </div>
            `,
                        showCloseButton: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            const btnEdit = document.getElementById('editRosterBtn');
                            const btnDelete = document.getElementById('deleteRosterBtn');

                            if (btnEdit) {
                                btnEdit.addEventListener('click', () => openEditRoster(event.id));
                            }

                            if (btnDelete) {
                                btnDelete.addEventListener('click', () => {
                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: "This roster will be permanently deleted!",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        cancelButtonColor: "#6c757d",
                                        confirmButtonText: "Yes, delete it!"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            fetch(`/rostering/${event.id}`, {
                                                    method: "DELETE",
                                                    headers: {
                                                        "X-CSRF-TOKEN": document
                                                            .querySelector(
                                                                'meta[name="csrf-token"]'
                                                                ).content,
                                                        "Accept": "application/json",
                                                    },
                                                })
                                                .then(response => {
                                                    if (!response.ok) throw new Error(
                                                        "Failed to delete roster"
                                                        );
                                                    return response.json();
                                                })
                                                .then(data => {
                                                    Swal.fire("Deleted!", data
                                                        .message ||
                                                        "Roster deleted successfully.",
                                                        "success");
                                                    calendar.refetchEvents();
                                                })
                                                .catch(error => {
                                                    console.error("Error:", error);
                                                    Swal.fire("Error!",
                                                        "Something went wrong while deleting.",
                                                        "error");
                                                });
                                        }
                                    });
                                });
                            }
                        }
                    });
                }

                // ✅ Edit form offcanvas loader
                function openEditRoster(id) {
                    Swal.close();
                    fetch(`/rostering/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('editRosterFormBody').innerHTML = data.form;
                            document.getElementById('editRosterForm').action = data.update_url;
                            new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster')).show();
                        })
                        .catch(() => Swal.fire('Error', 'Failed to load edit form.', 'error'));
                }
            });
        </script>
    @endpush

    @stack('scripts')




</body>

</html>
