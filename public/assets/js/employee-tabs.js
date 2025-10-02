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
    document.getElementById('formAddDoc')?.addEventListener('submit', e => {
        e.preventDefault();
        toast('Document uploaded (demo)');
        bootstrap.Modal.getInstance(document.getElementById('modalAddDoc')).hide();
    });
});