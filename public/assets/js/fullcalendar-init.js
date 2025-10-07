// document.addEventListener('DOMContentLoaded', function () {
//     const calendarEl = document.getElementById('calendar');
//     if (!calendarEl) return;

//     const events = (window.rosters || []).map(r => ({
//         id       : r.id,
//         title    : `${r.employee.first_name} ${r.employee.last_name} → ${r.service_user.first_name} ${r.service_user.last_name}`,
//         start    : r.start,
//         end      : r.end,
//         color    : r.status === 'cancelled' ? '#dc3545' : '#28a745',
//         extendedProps: {
//             status : r.status,
//             empName: `${r.employee.first_name} ${r.employee.last_name}`,
//             suName : `${r.service_user.first_name} ${r.service_user.last_name}`,
//             travelH: r.travel_hours,
//             travelM: r.travel_minutes,
//         }
//     }));

//     const calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView : 'dayGridMonth',
//         headerToolbar: {
//             left  : 'prev,next today',
//             center: 'title',
//             right : 'dayGridMonth,timeGridWeek,listWeek'
//         },
//         editable     : true,
//         droppable    : true,
//         eventLimit   : true,
//         events       : events,
//         eventClick   : function(info) {
//             // popup detail
//             const p = info.event.extendedProps;
//             let html = `<strong>Task:</strong> ${info.event.title}<br>
//                         <strong>Status:</strong> <span class="badge bg-${info.event.color === '#dc3545' ? 'danger' : 'success'}">${p.status}</span><br>
//                         <strong>Travel:</strong> ${p.travelH}h ${p.travelM}m`;
//             Swal.fire({ title: 'Roster Details', html, showCloseButton: true });
//         },
//         dateClick    : function(info) {
//             // optional: open add roster off-canvas
//             const offCanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddRoster'));
//             offCanvas.show();
//             // set start date in form
//             document.querySelector('[name="start_date"]').value = info.dateStr;
//         }
//     });

//     calendar.render();
// });