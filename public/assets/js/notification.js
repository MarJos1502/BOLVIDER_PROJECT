function showToast(type, message) {

    toastr.option = {
        'progressBar' : true,
        'closeButton' : true,
    };

    switch(type) {
        case 'success':
            toastr.success(message);
            break
        case 'error':
            toastr.error(message);
            break
        case 'warning':
            toastr.warning(message);
            break
        case 'info':
            toastr.info(message);
            break
        default:
            toastr.info(message);
            break
    }
}