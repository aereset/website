<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /es/login/');
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['invitations_permissions']) || !$_SESSION['invitations_permissions']) {
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
		echo '<li class="current">Invitar</li>';
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
	<p>Puedes invitar a otras personas a unirse a nosotros o compartir permisos con otros usuarios. Ten en cuenta que todas estas acciones serán registradas y asociadas a tu usuario por razones de seguridad, así que intenta crear invitaciones sólo para personas en quien confíes o reduce sus permisos a los mínimos necesarios.</p>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('invite', array('email*', 'admin', 'company', 'student', 'invitations', 'statistics', 'permissions', 'banners'))) {

?>

	<form action="" method="post">
		<fieldset>
			<legend>Formulario de invitación:</legend>
			<p class="info">Por favor, selecciona los permisos que quieras compartir con el usuario. Puedes compartir, como máximo, tus propios permisos (aquellos que se listan a continuación):</p>
			<div class="form_wrapper">
<?php

	if (isset($_SESSION['admin_permissions']) && $_SESSION['admin_permissions'] == 1) {

?>

				<input name="admin" id="form_admin" value="1" type="checkbox" />
				<label for="form_admin" class="checkbox_label">El usuario es administrador</label>

<?php

	}

	if (isset($_SESSION['company_permissions']) && $_SESSION['company_permissions'] == 1) {

?>

				<input name="company" id="form_company" value="1" type="checkbox" />
				<label for="form_company" class="checkbox_label">El usuario es una compañía</label>

<?php

	}

	if (isset($_SESSION['student_permissions']) && $_SESSION['student_permissions'] == 1) {

?>

				<input name="student" id="form_student" value="1" type="checkbox" />
				<label for="form_student" class="checkbox_label">El usuario es un estudiante</label>

<?php

	}

	if (isset($_SESSION['invitations_permissions']) && $_SESSION['invitations_permissions'] == 1) {

?>

				<input name="invitations" id="form_invitations" value="1" type="checkbox" />
				<label for="form_invitations" class="checkbox_label">El usuario puede crear invitaciones</label>

<?php

	}

	if (isset($_SESSION['statistics_permissions']) && $_SESSION['statistics_permissions'] == 1) {

?>

				<input name="statistics" id="form_statistics" value="1" type="checkbox" />
				<label for="form_statistics" class="checkbox_label">El usuario puede ver estadísticas de la página web</label>

<?php

	}

	if (isset($_SESSION['wiki_permissions']) && $_SESSION['wiki_permissions'] == 1) {

?>

				<input name="wiki" id="form_wiki" value="1" type="checkbox" />
				<label for="form_wiki" class="checkbox_label">El usuario puede editar contenidos</label>

<?php

	}

	if (isset($_SESSION['banners_permissions']) && $_SESSION['banners_permissions'] == 1) {

?>

				<input name="banners" id="form_banners" value="1" type="checkbox" />
				<label for="form_banners" class="checkbox_label">El usuario puede editar los anuncios de la web</label>
<?php

	}

?>
			</div>
			<div class="form_wrapper">
				<label for="form_email" class="singleline">Correo electrónico de tu amig@: <span class="form_required" title="This field is required">*</span></label>
				<input type="email" maxlength="60" name="email" id="form_email" class="singleline" required="required" />
			</div>
		</fieldset>
		<input  type="hidden" name="type" value="invite" />
		<input type="submit" value="Invitar" accesskey="x" />
	</form>

<?php

	}

?>

</article>
<footer>
	<p class="section_title">Mi cuenta</p>
</footer>
</section>
