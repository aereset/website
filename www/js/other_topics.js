
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

window.onload = display_other_topics;
