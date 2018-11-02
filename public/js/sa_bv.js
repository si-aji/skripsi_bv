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

// Sweet Alert
function showSuccess_redirect(message, url){
    swal({
        title: "Success!",
        text: message,
        icon: "success",
        button: "Redirect me now!",
        timer: 1500,
    }).then((value) => {
        document.location.href = url;
    });
}

// IDR Currency
function idr_curr(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return "Rp "+x1 + x2;
}

//Unescpape HTML
function unescapeHtml(safe) {
    return safe.replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#039;/g, "'");
}
