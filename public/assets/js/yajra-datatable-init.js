// Global settings for every Yajra DataTable
$.extend(true, $.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    responsive: true,
    pageLength: 25,
    lengthMenu: [10, 25, 50, 100],
    language: {
        search: "Quick search:",
        lengthMenu: "Show _MENU_ rows",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        paginate: { previous: "&laquo;", next: "&raquo;" }
    },
    dom:
        "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
});