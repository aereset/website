// Change language "on click"
document.getElementById('lang_sel_options').addEventListener('change', function () {
	this.form.submit();
}, false);

// Hide "Change" button
document.getElementById('lang_change_button').style.display = 'none';
