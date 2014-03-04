<section id="content">
<header>
	<h1>Invitación</h1>
</header>
<article>
	<header>
		<h1>¡Bienvenid@!</h1>
		<hr />
	</header>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('invitation', array('user*', 'pass*', 'pass2'))) {

?>

	<p>Por favor, introduce los datos necesarios a continuación para añadir tu usuario a nuestra base de datos.</p>
	<form action="" method="post">
		<fieldset>
			<legend>Información de usuario:</legend>
			<div class="form_warp">
				<label for="form_user" class="singleline">Usuario: <span class="form_required" title="This field is required">*</span></label>
				<input type="text" maxlength="30" name="user" id="form_user" class="singleline" required="required" value="<?php if (isset($sd['user'])) echo $sd['user']; ?>" />
				<label for="form_pass" class="singleline">Contraseña: <span class="form_required" title="This field is required">*</span></label>
				<input type="password" maxlength="60" name="pass" id="form_pass" class="singleline" required="required" />
				<label for="form_pass2" class="singleline">Contraseña (otra vez, para nuevos usuarios):</label>
				<input type="password" maxlength="60" name="pass2" id="form_pass2" class="singleline" />
			</div>
		</fieldset>
		<input type="hidden" name="type" value="invitation" />
		<input type="submit" value="Registro" accesskey="x" />
	</form>

<?php

	} else {

		echo '<p class="info">¡Tu usuario ha sido actualizado en nuestra base de datos! Ahora ya puedes <a href="/es/login/">ir a la página de inicio de sesión</a>.</p>';

	}

?>

</article>
<footer>
	<p class="section_title">Invitación<p>
</footer>
</section>
