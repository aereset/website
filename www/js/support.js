// Identifying when the user has an unsupported browser
var UNSUPPORTED_BROWSER = 0;

if (navigator.appName == 'Microsoft Internet Explorer') {
	// Get IE version
	var ie_version = parseInt(String(navigator.appVersion).split('MSIE')[1]);
	// Suggest to update/change browser in case IE version < 9
	if (ie_version < 9) {
		if (document.documentElement.lang == "es") {
			document.write('<p id="support_error">Estás utilizando Internet Explorer ' + ie_version + '...  Reset te recomienda actualizar tu navegador o utilizar uno mejor como Firefox, Google Chrome, Safari u Opera! (Son todos gratuitos): <a id="support_link" href="http://www.mozilla.com/firefox/" title="Descarga la última versión de Firefox">¡descarga la última versión de Firefox aquí!</a></p>');
		} else {
			document.write('<p id="support_error">You are using Internet Explorer ' + ie_version + '... Reset recommends you to upgrade your browser or use a better one like Firefox, Google Chrome, Safari or Opera! (They are all free): <a id="support_link" href="http://www.mozilla.com/firefox/" title="Download latest version of Firefox">download the latest version of Firefox here!</a></p>');
		}
		// Toggle UNSUPPORTED_BROWSER
		UNSUPPORTED_BROWSER = 1;
	}
} else if (navigator.appName == 'Netscape') {
	// Get Firefox version
	var fx_version = parseInt(String(navigator.userAgent).split('Firefox/')[1].split('.')[0]);
	// Suggest to update browser in case Firefox version < 4
	if (fx_version < 4) {
		if (document.documentElement.lang == "es") {
			document.write('<p id="support_error">Estás utilizando Firefox ' + fx_version + '... Reset te recomienda actualizar tu navegador: <a id="support_link" href="http://www.mozilla.com/firefox/" title="Descarga la última versión de Firefox">¡descarga la última versión de Firefox aquí!</a></p>');
		} else {
			document.write('<p id="support_error">You are using Firefox ' + fx_version + '... Reset recommends you to upgrade your browser: <a id="support_link" href="http://www.mozilla.com/firefox/" title="Download latest version of Firefox">download the latest version of Firefox here!</a></p>');
		}
		// Toggle UNSUPPORTED_BROWSER
		UNSUPPORTED_BROWSER = 1;
	}
}

// If the browser is not supported, apply some style to the alert
if (UNSUPPORTED_BROWSER) {
	var p = document.getElementById('support_error');
		p.style.textAlign = 'center';
		p.style.fontWeight = 'bold';
		p.style.padding = '.5em';
		p.style.color = '#ffffff';
		p.style.background = '#aa0000';
		p.style.border = '2px solid red';

	var link = document.getElementById('support_link');
		link.style.color = 'white';
		link.style.fontWeight = 'bold';
		link.style.textDecoration = 'underline';
}
