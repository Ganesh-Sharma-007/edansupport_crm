/* Employee edit tabs: calendar & placeholders */
document.addEventListener('DOMContentLoaded', () => {
    /* Rosters calendar */
    const calEl = document.getElementById('empCalendar');
    if (calEl) {
        const calendar = new FullCalendar.Calendar(calEl, {
            initialView : 'dayGridMonth',
            headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
            editable     : false,
            events       : `/api/employees/${window.empId}/rosters`,
            eventColor   : '#0d6efd'
        });
        calendar.render();
    }

    /* Folder create stub */
    document.getElementById('formCreateFolder')?.addEventListener('submit', e => {
        e.preventDefault();
        toast('Folder created (demo)');
        bootstrap.Modal.getInstance(document.getElementById('modalCreateFolder')).hide();
    });

    /* Document upload stub */
    // document.getElementById('formAddDoc')?.addEventListener('submit', e => {
    //     e.preventDefault();
    //     toast('Document uploaded (demo)');
    //     bootstrap.Modal.getInstance(document.getElementById('modalAddDoc')).hide();
    // });

});











// document.addEventListener('DOMContentLoaded', function () {
//     const calendarEl = document.getElementById('empCalendar');

//     if (!calendarEl || typeof window.empId === 'undefined') {
//         console.warn('Calendar container or empId missing');
//         return;
//     }

//     let calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         themeSystem: 'bootstrap5',
//         height: 650,
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'dayGridMonth,timeGridWeek,listWeek'
//         },
//         events: `/employees/${window.empId}/rosters`,
//         eventDidMount: function (info) {
//             new bootstrap.Tooltip(info.el, {
//                 title: `${info.event.title} (${info.event.extendedProps.status})`,
//                 placement: 'top',
//                 trigger: 'hover'
//             });
//         },
//     });

//     // Lazy render on tab activation
//     const tab = document.querySelector('#rosters-tab');
//     if (tab) {
//         tab.addEventListener('shown.bs.tab', () => {
//             calendar.render();
//         });
//     }
// });
