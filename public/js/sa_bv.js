// Show Top Right Notification (Bootstrap Notify)
function topright_notify(message){
    $.notify({
        icon: "done",
        title: "<strong>Success</strong>",
        message: message
    }, {
        type: "success",
        timer: 1500,
        delay: 500,
        newest_on_top: true,
        placement: {
            from: "top",
            align: "right"
        }
    });
}
