<?php

// TODO: remove this lines (print results instead of use redirection)
if ($_GET['search_for']) {
	$search_google_m = 'http://www.google.es/m/search?q=' . $_GET['search_for'] . '&hl=' . $lang . '&as_sitesearch=induforum.etsii.upm.es';
	header("Location: " . $search_google_m);
}

?>
<section id="content">
	<header>
		<h1>Search</h1>
		<h2>Based on Google's results</h2>
	</header>
	<article>
		<form accept-charset="utf-8" method="get" action="./">
			<fieldset>
				<legend>Search form</legend>
				<p class="warning">
					<strong>Info:</strong> we haven't already implemented a search engine, so this search form will redirect you to Google's results.
				</p>
				<div class="form_wrapper">
					<label for="form_search_input">Search:</label>
					<input type="search" placeholder="Search in this website" name="search_for" id="form_search_input" title="Type in to search in this website" required="required" />
					<input type="submit" value="Go" />
				</div>
			</fieldset>
		</form>
		<?php
			if ($_GET['search_for']) {
				// TODO: print search results here and delete lines 8-12 (avoid redirection)
			}
		?>
	</article>
	<footer>
		<p class="section_title">Search</p>
	</footer>
</section>
