/*
	wiki2HTML Parses wiki markup and generates HTML 5 showing a preview.
    Copyright (C) 2010-2011 Elia Contini

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see http://www.gnu.org/licenses/.

    Modified by:
	  Jesús Arroyo Torrens <jesus.jkhlg@gmail.com>
	  Miguel Sánchez de León Peque <msdeleonpeque@gmail.com>
 */

// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/regexp

/*
 * TODO list:
 *
 *   - Anchors: allow optional title parameter.
 *   - Images: review the code and complete it: figures, pictures, images...
 *   - Titles: wrap titles in <hgroup> if possible.
 *   - Tables: caption, thead, tbody... (see content-example.php)
 *   - List items with sub items (https://github.com/lahdekorpi/Wiky.php/blob/master/wiky.inc.php)
 */

exports.wiki2html = function (wikicode)
{
	var html = '<p>ERROR: function wiki2html(wikicode) could not complete the parsing.</p>';

	wikicode = deleteCR(wikicode);
	wikicode = comments(wikicode);
	wikicode = section_nav(wikicode);
	wikicode = headers(wikicode);
	wikicode = horizontalRule(wikicode);
	wikicode = wide_link(wikicode);
	wikicode = inlineElement(wikicode);
	wikicode = list(wikicode);
	wikicode = table(wikicode);
	wikicode = paragraph(wikicode);

	html = wikicode;

	return html;
}

/* this function normalize line breaks
 * in order to have a common base string
 * for all browser
 */
function deleteCR(wikicode)
{
	wikicode = wikicode.replace(/\r/g, '');
	return wikicode;
}

function comments(wikicode)
{
	var comments_regex = /^%.*/gm;

	wikicode = wikicode.replace(comments_regex, '');

	return wikicode;
}

function section_nav(wikicode)
{
	var heading_1_regex = /^={1}([^\[=]*)={1}$/gm;
	var heading_1_matches = wikicode.match(heading_1_regex);
	var section_nav_list = '';

	// Abort in case no matches found
	if (!heading_1_matches) return '<article>\n' + wikicode;

	// Generate navigation menu only if more than one header found
	if (heading_1_matches.length > 1) {
		section_nav_list = '<nav id="section_nav"><ul>';

		for (i=0; i<heading_1_matches.length; i++) {
			section_nav_list += '<li><a href="#' + heading_1_matches[i].replace(heading_1_regex, "$1") + '">'  + i + ' - ' + heading_1_matches[i].replace(heading_1_regex, "$1") +  '</a></li>';
		}

		section_nav_list += '</ul></nav>';
	}

	section_nav_list += '<article>\n';

	wikicode = section_nav_list + wikicode;

	return wikicode;
}

function headers(wikicode)
{
	wikicode = wikicode.replace(/^={6}([^\[=]*)={6}$/gm, '<h6>$1</h6>');
	wikicode = wikicode.replace(/^={5}([^\[=]*)={5}$/gm, '<h5>$1</h5>');
	wikicode = wikicode.replace(/^={4}([^\[=]*)={4}$/gm, '<h4>$1</h4>');
	wikicode = wikicode.replace(/^={3}([^\[=]*)={3}$/gm, '<h3>$1</h3>');
	wikicode = wikicode.replace(/^={2}([^\[=]*)={2}$/gm, '<h2>$1</h2>');
	wikicode = wikicode.replace(/^={1}([^\[=]*)={1}$/gm, '</article><article><h1 id="$1">$1</h1>');
	wikicode = wikicode + '\n</article>'
	wikicode = wikicode.replace(/<article>[\s]*?<\/article>/gm, ''); // First article is usually empty

	return wikicode;
}

function horizontalRule(wikicode)
{
	var horizontalLine = /-{4}/g;

	wikicode = wikicode.replace(horizontalLine, '<hr>');

	return wikicode;
}

function wide_link(wikicode)
{
	wide_link_regex = /^\[\[@:(.+?)\|([^\|]+)\|([^\|]+)?\]\]$/gm;

	while (tokens = wide_link_regex.exec(wikicode)) {
		if (typeof(tokens[3]) == 'undefined') tokens[3] = '';
		wikicode = wikicode.replace(tokens[0], '<a class="cat" href="' + tokens[1] + '"><dl class="cat"><dt class="cat_name">' + tokens[2] + '</dt><dd class="cat_desc">' + tokens[3] + '</dd></dl></a>');
	}

	return wikicode;
}

function inlineElement(wikicode)
{
	var strongem = /'{5}(.*)'{5}/g;
	var strong = /'{3}(.*)'{3}/g;
	var em = /'{2}(.*)'{2}/g;
	var image = /\[\[(File|Image):(.[^\]|]*)(\|thumb|\|frame|\|picture)?(\|alt=.[^\]|]*)?(\|.[^\]|]*)?\]\]/gi;
	var youtube = /\[Youtube:(.+?)\]/gi;
	var anchor = /\[([^\s]*) ([a-zA-Z0-9].[^\]]*)\]/g;

	wikicode = wikicode.replace(strongem, '<strong><em>$1</em></strong>');
	wikicode = wikicode.replace(strong, '<strong>$1</strong>');
	wikicode = wikicode.replace(em, '<em>$1</em>');

	while (tokens = image.exec(wikicode))
		{
			var params = [];
			if (typeof(tokens[0]) != 'undefined') params[0] = tokens[0];
			if (typeof(tokens[1]) != 'undefined') params[1] = tokens[1];
			if (typeof(tokens[2]) != 'undefined') {
				if (tokens[2].indexOf("://") == -1) params[2] = ' src="/images' + tokens[2] + '" ';
				else params[2] = ' src="' + tokens[2] + '" ';
			}
			if (typeof(tokens[3]) != 'undefined') params[3] = ' class="' + tokens[3].replace('|', '') + '" ';
			if (typeof(tokens[4]) != 'undefined') params[4] = ' alt="' + tokens[4].replace('|alt=', '') + '" ';
			if (typeof(tokens[5]) != 'undefined') params[5] = '<figcaption>' + tokens[5].replace('|', '') + '</figcaption>';
			wikicode = wikicode.replace(params[0], '<figure' + params[3] + '><img' + params[2] + params[3] + params[4] + '>' + params[5] + '</figure>');
		}

	wikicode = wikicode.replace(youtube, '<p class="centered"><iframe class="youtube-player" width="640" height="385" src="http://www.youtube.com/embed/$1"></iframe></p>');
	wikicode = wikicode.replace(anchor, '<a href="$1">$2</a>');

	return wikicode;
}

function list(wikicode)
{
	// unordered
	var unorderedStartList = /\n\n<li>/gm; //|\r\n\r\n<li>
	var unorderedListItem = /^\*(.*)/gm;
	var unorderedEndList = /<\/li>\n(?!<li>)/gm; // |<\/li>\r\n(?!<li>)

	wikicode = wikicode.replace(unorderedListItem, '<li>$1</li>');
	wikicode = wikicode.replace(unorderedStartList, "\n\n<ul>\n<li>");
	wikicode = wikicode.replace(unorderedEndList, "</li>\n</ul>\n\n");

	// ordered
	var orderedStartList = /\n\n<li>/gm; // |\r\n\r\n<li> ///([^<\/li>][>]?[\n])<li>/g;
	var orderedListItem = /^#[:]?[#]* (.*)/gm;
	var orderedEndList = /<\/li>\n(?!<li>|<\/ul>)/gm; // |<\/li>\r\n(?!<li>|<\/ul>) ///<\/li>\n(?!<li>)/gm;

	wikicode = wikicode.replace(orderedListItem, '<li>$1</li>');
	wikicode = wikicode.replace(orderedStartList, "\n\n<ol>\n<li>");
	wikicode = wikicode.replace(orderedEndList, "</li>\n</ol>\n\n");

	return wikicode;
}

function table(wikicode)
{
	// http://www.mediawiki.org/wiki/Help:Tables
	var tableStart = /^\{\|/gm;
	var tableRow = /^\|-/gm;
	var tableHeader = /^!\s(.*)/gm;
	var tableData = /^\|\s(.*)/gm;
	var tableEnd = /^\|\}/gm;

	wikicode = wikicode.replace(tableStart, '<table><tr>');
	wikicode = wikicode.replace(tableRow, '</tr><tr>');
	wikicode = wikicode.replace(tableHeader, '<th>$1</th>');
	wikicode = wikicode.replace(tableData, '<td>$1</td>');
	wikicode = wikicode.replace(tableEnd, '</tr></table>');

	return wikicode;
}

function paragraph(wikicode)
{
	var paragraph = /^\n([0-9A-Za-z].*)\n/gm; ///\n\n([^#\*=].*)/gm; //|\r\n\r\n([^#\*=].*)
	var info = /^\n(?!<)\? (.+)*(?!>)\n/gm;
	var warning = /^\n(?!<)\?\? (.+)*(?!>)\n/gm;
	var error = /^\n(?!<)\?\?\? (.+)*(?!>)\n/gm;

	wikicode = wikicode.replace(paragraph, "\n<p>$1</p>\n");
	wikicode = wikicode.replace(info, "<p class=\"info\">$1</p>\n");
	wikicode = wikicode.replace(warning, "<p class=\"warning\">$1</p>\n");
	wikicode = wikicode.replace(error, "<p class=\"error\">$1</p>\n");

	return wikicode;
}
