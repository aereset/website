<?php

/**
 * @brief
 *   Helps processing form data and prevents security issues when
 *   handling databases.
 *
 * Checks if any data has been received, empty required inputs, database
 * connection and database charset. Also, sanitizes the form inputs
 * (further data validation should be done in the processing file).
 * After that, it will include the corresponding form processing file.
 *
 * Sanitized fields will be available in the $sd vector as
 * $sd['variable']. Being 'variable' the name defined in $form_fields
 * parameter, which should be the same as the name in the form's input
 * field.
 *
 * Example:
 *
 *   form_to_db('invitation_form', array('user*', 'pass*', 'pass2*'))
 *
 * @param[in] form_type
 *   Form input and hidden field named "type". Will be used to check if
 *   the form has already been sent. Also, the processing file must be
 *   found in "data/form_processing/" and named "type.php".
 * @param[in] form_fields
 *   Form input fields that will be processed. Use the "name" attribute
 *   and add an '*' at the end for required inputs.
 * @return
 *   1 if an error occurred.
 *   0 otherwise.
 * @author
 *   Miguel Sánchez de León Peque <msdeleonpeque@gmail.com>
 * @date
 *   2013/02/03
 */
function form_to_db($form_type, $form_fields) {

	// Check if post data exists to be processed
	if (!isset($_POST['type'])) {
		return 1;
	}

	require_once(strstr(getcwd(), '/build', 1).'/data/messages.php');

	// Check if the form type is the correct one
	if ($_POST['type'] != $form_type) {
		echo $err_wrong_form_type;
		return 1;
	}

	require_once(strstr(getcwd(), '/build', 1).'/config.php');

	// Initialization
	unset($input_error);
	unset($real_form_fields);
	unset($processing_error);

	global $sd;
	global $input_error;
	$real_form_fields = array();

	foreach ($form_fields as $v) {
		if (substr($v, -1) == '*') {
			$v = substr($v, 0, -1);
			if ($_POST[$v] == "") $input_error[$v] = 1;
		}
		array_push($real_form_fields, $v);
	}

	// Check if all required fields have a non-empty value
	if (isset($input_error)) {
		foreach ($input_error as $v) {
			if ($v) {
				echo $warn_incomplete_form;
				return 1;
			}
		}
	}

	// Connect to the database
	$db = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	// Check for database connection errors
	if (mysqli_connect_errno()) {
		echo $err_db_connection_error;
		return 1;
	}

	// Try to set charset
	if (!mysqli_set_charset($db, 'utf8')) {
		echo $err_db_charset_error;
		mysqli_close($db);
		return 1;
	}

	// Sanitize data
	foreach ($real_form_fields as $v) {
		// No need to sanitize fields which are not defined (ex.: checkboxes not cheked)
		if (isset($_POST[$v])) $sd[$v] = mysqli_real_escape_string($db, trim($_POST[$v]));
	}

	// Include the corresponding form processing file
	require(strstr(getcwd(), '/build', 1).'/data/form_processing/'.$form_type.'.php');

	// Close database connection
	mysqli_close($db);

	// Check for processing errors
	if (isset($processing_error) && $processing_error) {
		return 1;
	}

	return 0;

}

?>
