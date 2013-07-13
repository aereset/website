<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /es/login/');
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['admin_permissions']) || !$_SESSION['admin_permissions']) {
		header('Location: /es/restricted_area/');
		exit;
	}

?>

<section id="content">
<header>
	<hgroup>
		<h1>Mi cuenta</h1>
	</hgroup>
</header>
<article>
	<nav class="tabs_nav">
		<ul>
			<li><a href="/es/my_account/session/">Sesión</a></li>
			<li><a href="/es/my_account/password/">Contraseña</a></li>
<?php
	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions']) {
		echo '<li><a href="/es/my_account/invite/">Invitar</a></li>';
	}
	if (isset($_SESSION['statistics_permissions']) && $_SESSION['statistics_permissions']) {
		echo '<li><a href="/es/my_account/statistics/">Estadísticas</a></li>';
	}
	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions']) {
		echo '<li class="current">Administración</li>';
	}
?>
		</ul>
	</nav>
	<div class="tabs_nav_div"></div>

	<form class="float_left" action="" method="post">
		<input  type="hidden" name="type" value="git_pull" />
		<input type="submit" value="Pull" accesskey="x" />
	</form>

	<form class="float_left" action="" method="post">
		<input  type="hidden" name="type" value="make" />
		<input type="submit" value="Make" accesskey="x" />
	</form>

	<form class="float_left" action="" method="post">
		<input  type="hidden" name="type" value="wikiregen" />
		<input type="submit" value="Wikiregen" accesskey="x" />
	</form>

	<form class="clear_both">
		<textarea rows="20" cols="20">
<?php

	unset($output);

	set_time_limit(60);
	if (isset($_POST['type']) && $_POST['type'] == 'git_pull') {

		echo exec("git pull 2>&1", $output);
		foreach ($output as $line) {
			echo "$line\n";
		}

	}

	if (isset($_POST['type']) && $_POST['type'] == 'make') {

		exec("../../generate 2>&1", $output);
		foreach ($output as $line) {
			echo "$line\n";
		}

	}

	if (isset($_POST['type']) && $_POST['type'] == 'wikiregen') {

		exec("../../wiki_recreate_all 2>&1", $output);
		foreach ($output as $line) {
			echo "$line\n";
		}

	}

?>
		</textarea>
	</form>

</article>
<footer>
	<p class="section_title">Mi cuenta</p>
</footer>
</section>
