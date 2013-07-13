<?php

	session_start();

	ob_start();

	// Check user logged in
	if (isset($_SESSION['user_id'])) {
		header('Location: /es/my_account/');
		exit;
	}

?>

<section id="content">
<header>
	<hgroup>
		<h1>Iniciar sesión</h1>
	</hgroup>
</header>
<article>
	<header>
		<hgroup>
			<h1 id="Formulario_de_acceso">Formulario de acceso</h1>
		</hgroup>
		<hr />
	</header>
	<p>
		Si eres estudiante, utiliza tu <strong>número de matrícula</strong> como <em>Usuario</em> y tu <strong>DNI</strong> como <em>Contraseña</em> (incluyendo ceros y excluyendo la letra de verificación).
		<p>
		Si no puedes acceder envía un correo a: <em>alta@induforum.es</em>
		</p>
	</p>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('login', array('user*', 'pass*'))) {

?>

	<form action="" method="post">
		<fieldset>
			<legend>Log in:</legend>
			<div class="form_warp">
				<label for="form_user" class="singleline">Usuario: <span class="form_required" title="This field is required">*</span></label>
				<input type="text" maxlength="30" name="user" id="form_user" class="singleline" required="required" value="<?php if (isset($sd['user'])) echo $sd['user']; ?>" />
				<label for="form_pass" class="singleline">Contraseña: <span class="form_required" title="This field is required">*</span></label>
				<input type="password" maxlength="60" name="pass" id="form_pass" class="singleline" required="required" />
			</div>
		</fieldset>
		<input type="hidden" name="type" value="login" />
		<input type="submit" value="Entrar" accesskey="x" />
	</form>

<?php

	} else {

		if (!isset($_SESSION['user_do_not_have_permissions'])) {
			if ($_SESSION['admin_permissions']) {
				header('Location: /my_account/?lang=es');
				exit;
			} else if ($_SESSION['student_permissions']) {
				header('Location: /es/students/participate/');
				exit;
			} else if ($_SESSION['company_permissions']) {
				header('Location: /es/companies/database/');
				exit;
			} else {
				header('Location: /es/my_account/');
				exit;
			}
		} else {
			header('Location: /es/undef-permissions/');
			exit;
		}

	}

?>


</article>

<footer>
	<p class="section_title">Iniciar sesión</p>

</footer>

</section>


