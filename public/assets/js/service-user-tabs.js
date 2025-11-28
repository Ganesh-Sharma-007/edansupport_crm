// document.addEventListener('DOMContentLoaded', () => {
//     /* Appointment calendar */
//     const calEl = document.getElementById('suCalendar');
//     if (calEl) {
//         const calendar = new FullCalendar.Calendar(calEl, {
//             initialView : 'dayGridMonth',
//             headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
//             events       : `/api/service-users/${window.suId}/appointments`,
//             eventColor   : '#0dcaf0'
//         });
//         calendar.render();
//     }

//     /* Health upload stub */
//     document.querySelectorAll('.health-upload').forEach(form => {
//         form.addEventListener('submit', e => {
//             e.preventDefault();
//             toast('Health record added (demo)');
//             bootstrap.Modal.getInstance(form.closest('.modal')).hide();
//         });
//     });

//     /* Document upload stub */
//     document.getElementById('formSuDoc')?.addEventListener('submit', e => {
//         e.preventDefault();
//         toast('Document uploaded (demo)');
//         bootstrap.Modal.getInstance(document.getElementById('modalSuDoc')).hide();
//     });
// });


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

        // Load appointments
        events: `/api/service-users/${window.suId}/appointments`,

        dayMaxEvents: 3,

        eventDidMount: info => {
            if (info.event.extendedProps.tooltip) {
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
