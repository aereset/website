
function add_social_links() {

	var content;

	content = '<div id="social_networks" style="z-index:-1;float:right;margin:5px 0.5em 0 0;">';

	// Facebook
	content += '<a href="http://es-es.facebook.com/pages/Reset-ETSII/143717755727174" onmouseover=\'document.facebook.src="/images/banners/icon_facebook_on.png"\' onmouseout=\'document.facebook.src="/images/banners/icon_facebook_off.png"\' ><img src="/images/banners/icon_facebook_off.png" name="facebook" alt="facebook_icon_image" /></a>';

	// Twitter
	content += '<a href="http://twitter.com/#!/Reset_ETSII" onmouseover=\'document.twitter.src="/images/banners/icon_twitter_on.png"\' onmouseout=\'document.twitter.src="/images/banners/icon_twitter_off.png"\' ><img src="/images/banners/icon_twitter_off.png" name="twitter" alt="twitter_icon_image" /></a>';

	// Youtube
	content += '<a href="http://www.youtube.com/user/AEReset" onmouseover=\'document.youtube.src="/images/banners/icon_youtube_on.png"\' onmouseout=\'document.youtube.src="/images/banners/icon_youtube_off.png"\' ><img src="/images/banners/icon_youtube_off.png" name="youtube" alt="youtube_icon_image" /></a>';

	// Flickr
	content += '<a href="http://www.flickr.com/photos/aereset/" onmouseover=\'document.flickr.src="/images/banners/icon_flickr_on.png"\' onmouseout=\'document.flickr.src="/images/banners/icon_flickr_off.png"\' "><img src="/images/banners/icon_flickr_off.png" name="flickr" alt="flickr_icon_image" /></a>';

	content += '</div>';

	document.getElementById('w_header').insertAdjacentHTML("beforeBegin", content);

	var parent_element = document.getElementById('social_networks');
	var child_elements = parent_element.getElementsByTagName('a');

	for (var i=0; i < child_elements.length; i++) {
		child_elements[i].style.margin = '0.2em';
	}
}

add_social_links();
