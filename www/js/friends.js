
function display_friends() {

	var friends = '';

	// Integra-e
	friends += '<p style="text-align:center;"><a href="http://www.ieeeuah.org/" title="IEEE - Rama de estudiantes de la UAH"><img src="/images/banners/ieee-uah.png" alt="IEEE - UAH" /></p>';

	document.getElementById('friends_block').insertAdjacentHTML("beforeEnd", friends);

}

window.onload = display_friends;
