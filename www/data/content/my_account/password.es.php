<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /es/login/');
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
			<li class="current">Contraseña</li>
<?php
	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions']) {
		echo '<li><a href="/es/my_account/invite/">Invitar</a></li>';
	}
	if (isset($_SESSION['statistics_permissions']) && $_SESSION['statistics_permissions']) {
		echo '<li><a href="/es/my_account/statistics/">Estadísticas</a></li>';
	}
	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions']) {
		echo '<li><a href="/es/my_account/administration/">Administración</a></li>';
	}
?>
		</ul>
	</nav>
	<div class="tabs_nav_div"></div>
	<p>Por razones de seguridad, te recomendamos cambiar la contraseña por defecto.</p>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('password_change', array('old_pass*', 'new_pass*', 'new_pass_verif*'))) {

?>

	<form action="" method="post">
		<fieldset>
			<legend>Cambia tu contraseña:</legend>
			<label for="form_old_pass" class="singleline">Antigua contraseña: <span class="form_required" title="This field is required">*</span></label>
			<input type="password" maxlength="60" name="old_pass" id="form_old_pass" class="singleline" required="required" />
			<label for="form_new_pass" class="singleline">Nueva contraseña: <span class="form_required" title="This field is required">*</span></label>
			<input type="password" maxlength="60" name="new_pass" id="form_new_pass" class="singleline" required="required" />
			<label for="form_new_pass_verif" class="singleline">Nueva contraseña, otra vez: <span class="form_required" title="This field is required">*</span></label>
			<input type="password" maxlength="60" name="new_pass_verif" id="form_new_pass_verif" class="singleline" required="required" />
		</fieldset>
		<input  type="hidden" name="type" value="password_change" />
		<input type="submit" value="Guardar" accesskey="x" />
	</form>

<?php

	}

?>

</article>
<footer>
	<p class="section_title">Mi cuenta</p>
</footer>
</section>
