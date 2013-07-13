<?php

// TODO: remove this lines (print results instead of use redirection)
if ($_GET['search_for']) {
	$search_google_m = 'http://www.google.es/m/search?q=' . $_GET['search_for'] . '&hl=' . $lang . '&as_sitesearch=induforum.etsii.upm.es';
	header("Location: " . $search_google_m);
}

?>
<section id="content">
	<header>
		<hgroup>
			<h1>Búsqueda</h1>
			<h2>Basada en los resultados de Google</h2>
		</hgroup>
	</header>
	<article>
		<form accept-charset="utf-8" method="get" action="./">
			<fieldset>
				<legend>Formulario de búsqueda</legend>
				<p class="warning">
					<strong>Información:</strong> todavía no hemos implementado un motor de búsqueda, así que esta búsqueda te redireccionará a los resultados de Google.
				</p>
				<div class="form_wrapper">
					<label for="form_search_input">Búsqueda:</label>
					<input type="search" placeholder="Busca en este sitio web" name="search_for" id="form_search_input" title="Escribe para buscar en este sitio" required="required" />
					<input type="submit" value="Ir" />
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
		<p class="section_title">Búsqueda</p>
	</footer>
</section>
