
function display_collaborate() {

	var collaborate = '';

	// CAR-UPM
	collaborate += '<p style="text-align:center;"><a href="http://www.car.upm-csic.es/" title="Centro de Automática y Robótica (CAR UPM-CSIC)"><img src="/images/banners/car_extended.png" alt="car_logo" /></a></p>';

	// CEI-UPM
	collaborate += '<p style="text-align:center;"><a href="http://www.cei.upm.es/" title="Centro de Electrónica Industrial (CEI-UPM)"><img src="/images/banners/cei_extended.png" alt="cei_logo" /></a></p>';

	// ETSII-UPM
	collaborate += '<p style="text-align:center;"><a href="http://www.etsii.upm.es/" title="Escuela Técnica Superior de Ingenieros Industriales"><img src="/images/banners/etsii_upm.png" alt="etsii_logo" /></a></p>';

	// UPM
	collaborate += '<p style="text-align:center;"><a href="http://www.upm.es/" title="Universidad Politécnica de Madrid"><img src="/images/banners/upm.png" alt="upm_logo" /></a></p>';
	
	// bq
	collaborate += '<p style="text-align:center;"><a href="http://www.bq.com/" title="bq"><img src="/images/banners/bq.png" alt="bq_logo" /></a></p>';
	
	document.getElementById('collaborate_block').innerHTML = collaborate;

}

function display_friends() {

	var friends = '';

	// Integra-e
	friends += '<p style="text-align:center;"><a href="http://www.ieeeuah.org/" title="IEEE - Rama de estudiantes de la UAH"><img src="/images/banners/ieee-uah.png" alt="IEEE - UAH" /></p>';

	document.getElementById('friends_block').innerHTML = friends;

}

function display_other_topics() {

	var other_topics = '';

	// Integra-e
	other_topics += '<p style="text-align:center;"><a href="http://integrae.org/" title="Integra-e website"><img src="/images/banners/integra-e.png" alt="Integra-e" /></p>';

	// Play Ogg banner
	other_topics += '<p style="text-align:center;"><a href="http://playogg.org/" title="Join PlayOgg, a campaign to promote the use of free media formats including Ogg Vorbis and Ogg Theora."><img src="/images/banners/play_ogg_large.png" alt="Play Ogg" /></a></p>';

	// ODF banner
	other_topics += '<p style="text-align:center;"><a href="http://www.fsf.org/campaigns/opendocument/" title="Open Document Format"><img src="/images/banners/odf.png" alt="Open Document Format" /></a></p>';

	document.getElementById('other_topics_block').innerHTML = other_topics;

}

function display_banners() {

	display_collaborate();
	display_friends();
	display_other_topics();

}

window.addEventListener('load', function() {
	display_banners();
}, false);
