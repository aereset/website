function create_header(lang) {
		var header;
		var title;
		var subtitle;
		if (lang == 'es') {
			title = document.getElementById('form_title_es').value;
			subtitle = document.getElementById('form_subtitle_es').value;
		} else {
			title = document.getElementById('form_title_en').value;
			subtitle = document.getElementById('form_subtitle_en').value;
		}
		header = '<header><hgroup><h1>' + title + '</h1><h2>' + subtitle + '</h2></hgroup></header>';
		return header;
	}

	function create_content(lang) {
		var content;
		if (lang == 'es') content = document.getElementById('form_wiki_content_es').value;
		else content = document.getElementById('form_wiki_content_en').value;
		content = wiki2html(content);
		return content;
	}

	function create_footer(lang) {
		var footer;
		if (lang == 'es') footer = document.getElementById('form_title_es').value;
		else footer = document.getElementById('form_title_en').value;
		footer = '<footer><p class="section_title">' + footer + '</p></footer>';
		return footer;
	}

	function draw_preview(lang) {
		var parsed_content;
		parsed_content = create_header(lang);
		parsed_content += create_content(lang);
		parsed_content += create_footer(lang);
		document.getElementById('content').innerHTML = parsed_content;
	}

	function edition_javascript() {

		var main_nav = document.getElementById('main_nav');
		var r_aside = document.getElementById('r_aside');

		main_nav.style.display = 'none';
		r_aside.style.display = 'none';

		draw_preview('en');

		document.getElementById('form_wiki_content_en').addEventListener('keyup', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_wiki_content_en').addEventListener('focus', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_title_en').addEventListener('keyup', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_title_en').addEventListener('focus', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_subtitle_en').addEventListener('keyup', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_subtitle_en').addEventListener('focus', function () {
			draw_preview('en');
		}, false);
		document.getElementById('form_wiki_content_es').addEventListener('keyup', function () {
			draw_preview('es');
		}, false);
		document.getElementById('form_wiki_content_es').addEventListener('focus', function () {
			draw_preview('es');
		}, false);
		document.getElementById('form_title_es').addEventListener('keyup', function () {
			draw_preview('es');
		}, false);
		document.getElementById('form_title_es').addEventListener('focus', function () {
			draw_preview('es');
		}, false);
		document.getElementById('form_subtitle_es').addEventListener('keyup', function () {
			draw_preview('es');
		}, false);
		document.getElementById('form_subtitle_es').addEventListener('focus', function () {
			draw_preview('es');
		}, false);

	}

	window.onload = edition_javascript;
