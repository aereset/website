
function edit_page() {
	var content;
	var url;
	var href;

	url = window.location.pathname.split('/');
	lang = url[1];

	href = '/' + lang + '/wiki/?page=';

	for (var i = 2; i < url.length; i++) href = href + '/' + url[i];

	content = '<a id="edit_page" href="' + href + '"><img height="30px" src=/images/pencil.svg alt="pencil_image" /></a>';
	document.getElementById('content').getElementsByTagName('header')[0].insertAdjacentHTML("afterBegin", content);

	document.getElementById('edit_page').style.cssFloat = 'right';
	document.getElementById('edit_page').style.margin = '1.2em';
}

window.addEventListener('load', function() {
	edit_page();
}, false);
