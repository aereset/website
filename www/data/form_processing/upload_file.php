<?php

	/*
	 * Sanitize aditional data (ex: $_GET variables or any other data
	 * that you might be using for MySQL queries and that has not
	 * been sanitized yet)
	 */

	/*
	 * Form data has already been sanitized, so it should not be
	 * dangerous to use it for MySQL queries. Anyway, you should check
	 * that the data is in this variables is the one you are looking
	 * for: variable type, range...
	 *
	 * If you find an input error, you should set the variable
	 * $input_error['name'] to 1, being 'name' the name of the
	 * corresponding form input.
	 */

	/*
	 * If you find any other processing error, remember to set the
	 * variable $processing_error to '1'.
	 */

	if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {

		if ($_FILES["file"]["size"] < 8000000) {

			if ($_FILES["file"]["type"] == "application/pdf" ||
			    $_FILES["file"]["type"] == "image/jpeg" ||
			    $_FILES["file"]["type"] == "image/png" ||
			    $_FILES["file"]["type"] == "image/svg+xml" ||
			    $_FILES["file"]["type"] == "image/gif" ||
			    $_FILES["file"]["type"] == "video/ogg" ||
			    $_FILES["file"]["type"] == "video/webm" ||
			    $_FILES["file"]["type"] == "audio/ogg" ||
			    $_FILES["file"]["type"] == "audio/webm") {

				global $name;
				$name = preg_replace('@[^a-zA-Z0-9\-_]@', '', $_POST['name']);

				if ($name != "") {

					$file_extension = pathinfo($_FILES["file"]["name"]);
					$file_extension = $file_extension['extension'];

					if ($file_extension != "") $name = $name . '.' . $file_extension;

					if (!file_exists(strstr(getcwd(), '/build', 1).'/uploads/'.$name)) {

						if (!move_uploaded_file($_FILES["file"]["tmp_name"], strstr(getcwd(), '/build', 1).'/uploads/'.$name)) {

							echo $error_uploading_file;
							$processing_error = 1;

						} else {

							$command = 'rsync -r --delete '.strstr(getcwd(), '/build', 1).'/uploads '.strstr(getcwd(), '/build', 1).'/build ';
							exec($command, $cmd_output);

						}
					} else {

						echo '<p class="error">-- A file already exists with the same name! Please, retry with a different name. --</p>';
						$processing_error = 1;

					}

				} else {

					echo $warn_incomplete_form;
					echo '<p class="warning">-- Please, set a file. --</p>';
					$processing_error = 1;

				}

			} else {

				echo $error_wrong_file_type;
				echo '<p class="warning">-- File must be of type: PDF, JPEG, PNG, SVG, GIF, Ogg or WebM. --</p>';
				$processing_error = 1;

			}

		} else {

			echo $error_file_too_large;
			echo '<p class="warning">-- MAX_SIZE = 8000000 Bytes --</p>';
			$processing_error = 1;

		}

	} else {

		echo $_FILES["file"]["error"];
		echo $error_uploading_file;
		$processing_error = 1;

	}

?>
