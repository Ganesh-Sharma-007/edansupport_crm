document.addEventListener('DOMContentLoaded', () => {
    /* Appointment calendar */
    const calEl = document.getElementById('suCalendar');
    if (calEl) {
        const calendar = new FullCalendar.Calendar(calEl, {
            initialView : 'dayGridMonth',
            headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
            events       : `/api/service-users/${window.suId}/appointments`,
            eventColor   : '#0dcaf0'
        });
        calendar.render();
    }

    /* Health upload stub */
    document.querySelectorAll('.health-upload').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            toast('Health record added (demo)');
            bootstrap.Modal.getInstance(form.closest('.modal')).hide();
        });
    });

    /* Document upload stub */
    document.getElementById('formSuDoc')?.addEventListener('submit', e => {
        e.preventDefault();
        toast('Document uploaded (demo)');
        bootstrap.Modal.getInstance(document.getElementById('modalSuDoc')).hide();
    });
});