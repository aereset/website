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

	// New password verification
	if ($sd['new_pass'] == $sd['new_pass_verif']) {

		// Try to get data from the users database
		$query = "select * from users where number='".$_SESSION['user_id']."'";
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($result);

		if (hash('sha512', $db_salt.$sd['old_pass']) == $row['password']) {

			$query = "update users set password='".hash('sha512', $db_salt.$sd['new_pass'])."' where number='".$_SESSION['user_id']."'";
			$result = mysqli_query($db, $query);

			if ($result) {

				echo $info_password_changed;

			} else {

				echo $err_writing_to_db;
				$processing_error = 1;

			}

		} else {

			echo $warn_wrong_old_password;
			$processing_error = 1;

		}

		mysqli_free_result($result);

	} else {

		echo $warn_passwords_not_match;
		$processing_error = 1;

	}

?>
