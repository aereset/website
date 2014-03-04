<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/?referer=/en/my_account/session/');
		exit;
	}

?>

<section id="content">
<header>
	<h1>My account</h1>
</header>
<article>
	<nav class="tabs_nav">
		<ul>
			<li class="current">Session</li>
			<li><a href="/en/my_account/password/">Password</a></li>
<?php
	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions']) {
		echo '<li><a href="/en/my_account/invite/">Invite</a></li>';
	}
	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions']) {
		echo '<li><a href="/en/my_account/administration/">Administration</a></li>';
	}
?>
		</ul>
	</nav>
	<div class="tabs_nav_div"></div>
	<p>To log out, click the button bellow:</p>
	<form action="/en/logout/" method="post">
		<input type="submit" value="Log out" accesskey="x" />
	</form>
</article>
<footer>
	<p class="section_title">My account</p>
</footer>
</section>
