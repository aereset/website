<?php

	session_start();

	$_SESSION = array();
	session_destroy();

?>

<section id="content">
<header>
	<h1>Logged out</h1>
</header>
<article>
	<header>
		<h1 id="Acess_form">Your session has been closed</h1>
		<hr />
	</header>
	<p>See you soon!</p>
</article>
<footer>
	<p class="section_title">Logged out</p>
</footer>

</section>
