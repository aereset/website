
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

	document.getElementById('collaborate_block').insertAdjacentHTML("beforeEnd", collaborate);

}

window.onload = display_collaborate;
