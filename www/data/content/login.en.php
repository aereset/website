<?php

	session_start();

	ob_start();

	// Check user logged in
	if (isset($_SESSION['user_id'])) {
		header('Location: /en/my_account/');
		exit;
	}

?>

<section id="content">
<header>
	<h1>Log in</h1>
</header>
<article>
	<header>
		<h1 id="Acess_form">Access form</h1>
		<hr />
	</header>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('login', array('user*', 'pass*'))) {

?>

	<form action="" method="post">
		<fieldset>
			<legend>Log in:</legend>
			<div class="form_warp">
				<label for="form_user" class="singleline">User: <span class="form_required" title="This field is required">*</span></label>
				<input type="text" maxlength="30" name="user" id="form_user" class="singleline" required="required" value="<?php if (isset($sd['user'])) echo $sd['user']; ?>" />
				<label for="form_pass" class="singleline">Password: <span class="form_required" title="This field is required">*</span></label>
				<input type="password" maxlength="60" name="pass" id="form_pass" class="singleline" required="required" />
			</div>
		</fieldset>
		<input type="hidden" name="type" value="login" />
		<input type="submit" value="Log in" accesskey="x" />
	</form>

<?php

	} else {

		if (!isset($_SESSION['user_do_not_have_permissions'])) {
			if (isset($_GET['referer'])) $referer = $_GET['referer'];
			else $referer = '/en/my_account/';
			header('Location: '.$referer);
			exit;
		} else {
			header('Location: /en/undef-permissions/');
			exit;
		}

	}

?>


</article>

<footer>
	<p class="section_title">Log in</p>

</footer>

</section>


