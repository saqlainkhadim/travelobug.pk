function ajaxErrorToastr(ajaxcontent) {

    if (ajaxcontent.hasOwnProperty('responseJSON')) {
        if (ajaxcontent.responseJSON.hasOwnProperty('message') && ajaxcontent.responseJSON.message != "" && ajaxcontent.status != 422) {
            toastr.error(ajaxcontent.responseJSON.message);
        } else if ((ajaxcontent.responseJSON.hasOwnProperty('errors') && ajaxcontent.responseJSON.errors.length != 0) || (ajaxcontent.responseJSON.hasOwnProperty('data') && ajaxcontent.responseJSON.data.length != 0)) {
            let errors_obj = (ajaxcontent.responseJSON.data) ? ajaxcontent.responseJSON.data : ajaxcontent.responseJSON.errors;
            if (typeof errors_obj == "string") {
                toastr.error(errors_obj);
            } else {
                $.each(errors_obj, function(index, value) {
                    $("#payment-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
            }
        } else if (ajaxcontent.hasOwnProperty('status')) {
            toastr.error(ajaxcontent.statusText + " " + ajaxcontent.status);
        }
    } else if (ajaxcontent.hasOwnProperty('responseText')) {
        toastr.error(ajaxcontent.responseText);
    } else if (ajaxcontent.hasOwnProperty('status') && ajaxcontent.hasOwnProperty('statusText')) {
        toastr.error(ajaxcontent.statusText + " " + ajaxcontent.status);
    } else {
        toastr.error("Something went wrong!");
    }
}

function ajaxSuccessToastr(ajaxcontent) {

    if (ajaxcontent.hasOwnProperty('responseJSON') && ajaxcontent.responseJSON.status == true) {
        if (ajaxcontent.responseJSON.hasOwnProperty('message')) {
            toastr.success(ajaxcontent.responseJSON.message);
        }
    } else if (ajaxcontent.hasOwnProperty('message')) {
        toastr.success(ajaxcontent.message);
    } else if (ajaxcontent.hasOwnProperty('status') && ajaxcontent.status == 200) {
        toastr.success("Operation Successful");
    } else {
        toastr.success("Operation Successful");
    }
}