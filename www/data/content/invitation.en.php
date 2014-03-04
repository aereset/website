<section id="content">
<header>
	<h1>Invitation</h1>
</header>
<article>
	<header>
		<h1>Welcome!</h1>
		<hr />
	</header>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('invitation', array('user*', 'pass*', 'pass2'))) {

?>

	<p>Please, introduce the required data below to add your user to our database.</p>
	<form action="" method="post">
		<fieldset>
			<legend>User information:</legend>
			<div class="form_warp">
				<label for="form_user" class="singleline">User: <span class="form_required" title="This field is required">*</span></label>
				<input type="text" maxlength="30" name="user" id="form_user" class="singleline" required="required" value="<?php if (isset($sd['user'])) echo $sd['user']; ?>" />
				<label for="form_pass" class="singleline">Password: <span class="form_required" title="This field is required">*</span></label>
				<input type="password" maxlength="60" name="pass" id="form_pass" class="singleline" required="required" />
				<label for="form_pass2" class="singleline">Password (again, for new users):</label>
				<input type="password" maxlength="60" name="pass2" id="form_pass2" class="singleline" />
			</div>
		</fieldset>
		<input type="hidden" name="type" value="invitation" />
		<input type="submit" value="Register" accesskey="x" />
	</form>

<?php

	} else {

		echo '<p class="info">Your user has been updated in our database! You can now <a href="/en/login/">go to the login page</a>.</p>';

	}

?>

</article>
<footer>
	<p class="section_title">Invitation<p>
</footer>
</section>
