
var last_canvas_width = $('#page_wrapper').width();

function canvas_draw_background()
{
	var canvas = document.getElementById('canvas_bg');

	// Canvas dimension
	var canvas_dimx = $('#page_wrapper').width();
	var canvas_dimy = $('#page_wrapper').height();

	// Check if low.css is loaded
	if ($('.hide_low').css('display') == 'none') canvas_dimy = 200;

	canvas.width = canvas_dimx;
	canvas.height = canvas_dimy;

	if (canvas.getContext){
		var context = canvas.getContext('2d');

		var x = 0;
		var y = 0;
		var row = 0;

		// Hexagon properties
		var L = 20;                            // L
		var e = 2*L*(1 - Math.SQRT1_2);        // d from center to center = 2*L
		var Dx = 2*(2*L)*Math.cos(Math.PI/6);  // dx from center to center (separated columns)
		var Dy = (2*L)*Math.sin(Math.PI/6);    // dy from center to center (all rows)
		var C = L*Math.cos(Math.PI/3);         // L*cos(PI/3);
		var S = L*Math.sin(Math.PI/3);         // L*sin(PI/3);

		while (y < canvas_dimy) {
			while (x < canvas_dimx) {

				var random_draw = Math.floor(Math.random()*10);

				if (random_draw == 1) {

					context.moveTo(x, y);
					context.fillStyle='rgba(0,204,255,' + (canvas_dimx - x)/canvas_dimx + ')';

					context.beginPath();
					context.moveTo(x + L, y);
					context.lineTo(x + C, y - S);
					context.lineTo(x - C, y - S);
					context.lineTo(x - L, y);
					context.lineTo(x - C, y + S);
					context.lineTo(x + C, y + S);
					context.fill();

				} else if ((random_draw == 2) || (random_draw == 3)) {

					context.moveTo(x, y);
					context.strokeStyle='rgba(0,204,255,' + (canvas_dimx - x)/canvas_dimx + ')';
					context.lineWidth = 3;

					context.beginPath();
					context.moveTo(x + L, y);
					context.lineTo(x + C, y - S);
					context.lineTo(x - C, y - S);
					context.lineTo(x - L, y);
					context.lineTo(x - C, y + S);
					context.lineTo(x + C, y + S);
					context.closePath();
					context.stroke();

				}

				x = x + Dx;

			}

			if (row % 2) x = 0;
			else x = Dx/2;
			y = y + Dy;
			row++;

		}

	} else {
		// canvas-unsupported code here
	}

}

function canvas_redraw_background()
{
	if (last_canvas_width != $('#page_wrapper').width()) {
		canvas_draw_background();
		last_canvas_width = $('#page_wrapper').width();
	}
}

window.addEventListener('load', function() {
	canvas_draw_background();
}, false);

window.addEventListener('resize', function() {
	canvas_redraw_background();
}, false);
