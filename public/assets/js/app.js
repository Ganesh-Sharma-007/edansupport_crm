// CSRF token for every AJAX call
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Helper to fire simple toast
window.toast = function (msg, icon = 'success') {
    Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon, title: msg });
};