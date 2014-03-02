<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/?referer=/en/wiki/upload/');
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['wiki_permissions']) || !$_SESSION['wiki_permissions']) {
		header('Location: /en/restricted_area/');
		exit;
	}

?>

<section id="content">
<header>
	<hgroup>
		<h1>Upload</h1>
	</hgroup>
</header>
<article>

<?php

	require_once(strstr(getcwd(), '/build', 1).'/data/form_to_db.php');

	if (form_to_db('upload_file', array(''))) {

?>

	<p>You can select a local file to upload to our server.</p>
	<form action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>File:</legend>
			<p class="info">Please choose an intelligible and readable file name with no special characters (they will be removed). Good name: <strong>"projectx_20140202_detail_view"</strong>. Bad names: "lol", "a53g"...</p>
			<div class="form_wrapper">
				<label for="form_file" class="singleline">File: <span class="form_required" title="This field is required">*</span></label>
				<input type="file" name="file" id="form_file" class="singleline" required="required" />
				<label for="form_name" class="singleline">Name with extension: <span class="form_required" title="This field is required">*</span></label>
				<input type="text" name="name" id="form_name" class="singleline" required="required" />
			</div>
		</fieldset>
		<input  type="hidden" name="type" value="upload_file" />
		<input type="submit" value="Upload" accesskey="x" />
	</form>

<?php

	} else {

?>

	<p class="info">Your file has been uploaded successfuly to the server! You can <a href="/en/uploads/<?php echo $name; ?>"> verify your upload</a>.</p>

<?php

		unset($name);

	}

?>

</article>
<footer>
	<p class="section_title">Upload</p>
</footer>
</section>
