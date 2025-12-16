document.addEventListener('DOMContentLoaded', () => {






    const calEl = document.getElementById('suCalendar');
    if (!calEl) return;

    const calendar = new FullCalendar.Calendar(calEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
            // height: 509,          // total calendar height
    contentHeight: 550,   // grid only
    // expandRows: false,    // prevents tall rows
        events: window.suRosterEvents || [],
        dayMaxEvents: 3,
        eventDidMount: info => {
            if (info.event.extendedProps?.tooltip) {
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.tooltip,
                    container: 'body'
                });
            }
        },
        eventClick: info => {
            const event = info.event;
            const props = event.extendedProps;

            Swal.fire({
                title: 'Appointment Details',
                html: `
                <strong>Title:</strong> ${event.title}<br>
                <strong>Date:</strong> ${event.startStr}<br>
                <strong>Status:</strong> ${props.status ?? 'NA'}<br>
                <strong>Notes:</strong> ${props.notes ?? 'No notes'}<br><br>

                <div class="text-center mt-3">
                    <button id="editApptBtn" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-edit me-1"></i> Edit
                    </button>
                    <button id="deleteApptBtn" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash me-1"></i> Delete
                    </button>
                </div>
            `,
                showCloseButton: true,
                showConfirmButton: false,
                didOpen: () => {

                    document.getElementById('editApptBtn')?.addEventListener('click', () => {
                        openEditAppointment(event.id);
                    });

                    document.getElementById('deleteApptBtn')?.addEventListener('click', () => {
                        deleteAppointment(event.id, calendar);
                    });
                }
            });
        }
    });

    calendar.render();

    /* Fix FullCalendar inside Bootstrap tabs */
    document.addEventListener('shown.bs.tab', (e) => {
        const target = e.target.getAttribute('data-bs-target')
            || e.target.getAttribute('href');

        if (!target) return;

        const tabPane = document.querySelector(target);
        if (tabPane && tabPane.contains(calEl)) {
            setTimeout(() => calendar.updateSize(), 50);
        }
    });


    // ================================
    //  EDIT Appointment (Offcanvas)
    // ================================
    function openEditAppointment(id) {
        Swal.close();
        fetch(`/appointments/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('editRosterFormBody').innerHTML = data.form;
                document.getElementById('editRosterForm').action = data.update_url;
                new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster')).show();
            })
            .catch(() => Swal.fire('Error', 'Failed to load edit form.', 'error'));
    }


    // ================================
    // DELETE Appointment
    // ================================
    function deleteAppointment(id, calendar) {

        Swal.fire({
            title: "Are you sure?",
            text: "This appointment will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {

            if (result.isConfirmed) {
                fetch(`/appointments/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire("Deleted!", data.message ?? "Appointment deleted.", "success");
                        calendar.refetchEvents();
                    })
                    .catch(() => {
                        Swal.fire("Error!", "Something went wrong while deleting.", "error");
                    });
            }
        });
    }






});
