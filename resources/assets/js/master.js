
function master_notification_proc(notification_text_string, notification_type_int, header_string) {
    // Toastr notifications counter, more than one from a type at the same time not allowed
    // notification_type: info(0), success(1), warning(2), error(3)
    howlong_stay = "3000";
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "500",
        "timeOut": howlong_stay,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    if (notification_type_int === 0) toastr["info"](notification_text_string, header_string);
    if (notification_type_int === 1) toastr["success"](notification_text_string, header_string);
    if (notification_type_int === 2) toastr["warning"](notification_text_string, header_string);
    if (notification_type_int === 3) toastr["error"](notification_text_string, header_string);
}