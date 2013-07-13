<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/');
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['invitations_permissions']) || !$_SESSION['invitations_permissions']) {
		header('Location: /en/restricted_area/');
		exit;
	}

?>

<section id="content">
<header>
	<hgroup>
		<h1>My account</h1>
	</hgroup>
</header>
<article>
	<nav class="tabs_nav">
		<ul>
			<li><a href="/en/my_account/session/">Session</a></li>
			<li><a href="/en/my_account/password/">Password</a></li>
<?php
	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions']) {
		echo '<li class="current">Invite</li>';
	}
	if (isset($_SESSION['statistics_permissions']) && $_SESSION['statistics_permissions']) {
		echo '<li><a href="/en/my_account/statistics/">Statistics</a></li>';
	}
	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions']) {
		echo '<li><a href="/en/my_account/administration/">Administration</a></li>';
	}
?>
		</ul>
	</nav>
	<div class="tabs_nav_div"></div>
	<p>You can invite other people to join us or share permissions with other users. Notice that all this actions will be registered and associated with your user for security reasons, so try to create invitations only for people you trust or reduce their permissions to the minimum required.</p>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('invite', array('email*', 'admin', 'company', 'student', 'invitations', 'statistics', 'permissions', 'banners'))) {

?>

	<form action="" method="post">
		<fieldset>
			<legend>Invitation form:</legend>
			<p class="info">Please, select which permissions you want to share with the user. You can share, at most, your own permissions (those which are listed bellow):</p>
			<div class="form_wrapper">

<?php

	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions'] == 1) {

?>

				<input name="admin" id="form_admin" value="1" type="checkbox" />
				<label for="form_admin" class="checkbox_label">The user is an administrator</label>

<?php

	}

	if (isset($_SESSION['company_permissions']) && $_SESSION['company_permissions'] == 1) {

?>

				<input name="company" id="form_company" value="1" type="checkbox" />
				<label for="form_company" class="checkbox_label">The user is a company</label>

<?php

	}

	if (isset($_SESSION['student_permissions']) && $_SESSION['student_permissions'] == 1) {

?>

				<input name="student" id="form_student" value="1" type="checkbox" />
				<label for="form_student" class="checkbox_label">The user is a student</label>

<?php

	}

	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions'] == 1) {

?>

				<input name="invitations" id="form_invitations" value="1" type="checkbox" />
				<label for="form_invitations" class="checkbox_label">The user can create invitations</label>

<?php

	}

	if (isset($_SESSION['statistics_permissions']) && $_SESSION['statistics_permissions'] == 1) {

?>

				<input name="statistics" id="form_statistics" value="1" type="checkbox" />
				<label for="form_statistics" class="checkbox_label">The user can see statistics about the database</label>

<?php

	}

	if (isset($_SESSION['wiki_permissions']) && $_SESSION['wiki_permissions'] == 1) {

?>

				<input name="wiki" id="form_wiki" value="1" type="checkbox" />
				<label for="form_wiki" class="checkbox_label">The user can edit contents</label>

<?php

	}

	if (isset($_SESSION['banners_permissions']) && $_SESSION['banners_permissions'] == 1) {

?>

				<input name="banners" id="form_banners" value="1" type="checkbox" />
				<label for="form_banners" class="checkbox_label">The user can edit website's banners</label>
<?php

	}

?>
			</div>
			<div class="form_wrapper">
				<label for="form_email" class="singleline">Your friend's email: <span class="form_required" title="This field is required">*</span></label>
				<input type="email" maxlength="60" name="email" id="form_email" class="singleline" required="required" />
			</div>
		</fieldset>
		<input  type="hidden" name="type" value="invite" />
		<input type="submit" value="Invite" accesskey="x" />
	</form>

<?php

	}

?>

</article>
<footer>
	<p class="section_title">My account</p>
</footer>
</section>
