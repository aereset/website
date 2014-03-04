<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/?referer=/en/my_account/administration/');
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['admin_permissions']) || !$_SESSION['admin_permissions']) {
		header('Location: /en/restricted_area/');
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
			<li><a href="/en/my_account/session/">Session</a></li>
			<li><a href="/en/my_account/password/">Password</a></li>
<?php
	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions']) {
		echo '<li><a href="/en/my_account/invite/">Invite</a></li>';
	}
	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions']) {
		echo '<li class="current">Administration</li>';
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
	<p class="section_title">My account</p>
</footer>
</section>
