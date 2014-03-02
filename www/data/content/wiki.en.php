<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/?referer=/en/wiki/?page='.$_GET['page']);
		exit;
	}

	// Check permissions
	if (!isset($_SESSION['wiki_permissions']) || !$_SESSION['wiki_permissions']) {
		header('Location: /en/restricted_area/');
		exit;
	}

	// Clean $_GET['page'] variable
	$page = preg_replace('@[^a-zA-Z0-9/\-_]@', '', $_GET['page']);

	if ($page != $_GET['page']) {
		header('Location: /en/wiki/?page='.$page);
		exit;
	}

	if ($page == '/') $page = 'index';

	$aux1 = '/'.$page.'/';
	$aux2 = preg_replace('@//@', '/', $aux1);

	if ($page != $aux2) {
		header('Location: /en/wiki/?page='.$aux2);
		exit;
	} else {
		$page = $aux2;
	}

	// Delete last slash from page and guess parent dir
	$page = preg_replace('@^(/.*)/$@', '\1', $_GET['page']);
	$dir = preg_replace('@^(.*)(/[^/]*)@', '\1', $page);

	$system_page_name = strstr(getcwd(), '/build', 1).'/data/content'.$page;
	$wiki_page_name = strstr(getcwd(), '/build', 1).'/wiki'.$page;
	$wiki_dir_name = strstr(getcwd(), '/build', 1).'/wiki'.$dir;

	if (file_exists($wiki_page_name)) {
		$wiki_file_en = $wiki_page_name.'/index.en.reset';
		$wiki_file_es = $wiki_page_name.'/index.es.reset';
	} else {
		$wiki_file_en = $wiki_page_name.'.en.reset';
		$wiki_file_es = $wiki_page_name.'.es.reset';
	}

	unset($cmd_output);
	unset($protected_file);
	unset($no_parent);

	if (file_exists($system_page_name.'.en.php') || file_exists($system_page_name.'.es.php') || file_exists($system_page_name.'.en.html') || file_exists($system_page_name.'.es.html') || file_exists($system_page_name.'/index.en.php') || file_exists($system_page_name.'/index.es.php') || file_exists($system_page_name.'/index.en.html') || file_exists($system_page_name.'/index.es.html')) {

		$protected_file = 1;

	} else if (!file_exists($wiki_dir_name) && !file_exists($wiki_dir_name.'.en.reset') && !file_exists($wiki_dir_name.'.es.reset')) {

		$no_parent = 1;

	}

	echo $wiki_dir_name;

	if (!isset($protected_file) && !isset($no_parent)) {

		// If form data has been sent, write it to the corresponding file
		if (isset($_POST['type']) && $_POST['type'] == 'wiki_form') {

			if (!file_exists($wiki_dir_name)) {
				$command = 'mkdir -p '.$wiki_dir_name.' 2>&1';
				exec($command, $cmd_output);
				$command = 'mv '.$wiki_dir_name.'.en.reset '.$wiki_dir_name.'/index.en.reset 2>&1';
				exec($command, $cmd_output);
				$command = 'mv '.$wiki_dir_name.'.es.reset '.$wiki_dir_name.'/index.es.reset 2>&1';
				exec($command, $cmd_output);
			}

			// Write English wiki file
			file_put_contents($wiki_file_en, '% TITLE='.$_POST['title_en']."\n");
			file_put_contents($wiki_file_en, '% SUBTITLE='.$_POST['subtitle_en']."\n", FILE_APPEND);
			file_put_contents($wiki_file_en, '% DESCRIPTION='.$_POST['description_en']."\n", FILE_APPEND);
			file_put_contents($wiki_file_en, '% KEYWORDS='.$_POST['keywords_en']."\n", FILE_APPEND);
			file_put_contents($wiki_file_en, preg_replace('/(\r\n)|(\r)/', "\n", $_POST['wiki_content_en']), FILE_APPEND);

			// Write Spanish wiki file
			file_put_contents($wiki_file_es, '% TITLE='.$_POST['title_es']."\n");
			file_put_contents($wiki_file_es, '% SUBTITLE='.$_POST['subtitle_es']."\n", FILE_APPEND);
			file_put_contents($wiki_file_es, '% DESCRIPTION='.$_POST['description_es']."\n", FILE_APPEND);
			file_put_contents($wiki_file_es, '% KEYWORDS='.$_POST['keywords_es']."\n", FILE_APPEND);
			file_put_contents($wiki_file_es, preg_replace('/(\r\n)|(\r)/', "\n", $_POST['wiki_content_es']), FILE_APPEND);

			// Generate those files in the build directory
			$wiki_create_script = strstr(getcwd(), '/build', 1).'/wiki_create';
			$wiki_dir = strstr(getcwd(), '/build', 1).'/wiki/';
			$command = $wiki_create_script.' '.$wiki_file_en.' 2>&1';
			exec($command, $cmd_output);
			$command = $wiki_create_script.' '.$wiki_file_es.' 2>&1';
			exec($command, $cmd_output);
			$command = 'git --git-dir='.$wiki_dir.'.git --work-tree='.$wiki_dir.' add -A 2>&1';
			exec($command, $cmd_output);
			$command = 'git --git-dir='.$wiki_dir.'.git --work-tree='.$wiki_dir.' commit -m "'.$_SESSION['user_id'].' - '.$wiki_page_name.'" 2>&1';
			exec($command, $cmd_output);
			$command = 'git --git-dir='.$wiki_dir.'.git --work-tree='.$wiki_dir.' push origin master 2>&1';
			exec($command, $cmd_output);
		}

		if (file_exists($wiki_file_en)) {
			$file_content_en = file($wiki_file_en);
			$file_comments_en = preg_grep('/^[%].*/', $file_content_en);
			$file_data_en = array();

			$i = 0;
			while (in_array($file_content_en[$i], $file_comments_en)) {
				if (strstr($file_content_en[$i], '% TITLE=')) $file_data_en[0] = preg_replace('@%.*=(.*)$@', '\1', $file_content_en[$i]);
				else if (strstr($file_content_en[$i], '% SUBTITLE=')) $file_data_en[1] = preg_replace('@%.*=(.*)$@', '\1', $file_content_en[$i]);
				else if (strstr($file_content_en[$i], '% DESCRIPTION=')) $file_data_en[2] = preg_replace('@%.*=(.*)$@', '\1', $file_content_en[$i]);
				else if (strstr($file_content_en[$i], '% KEYWORDS=')) $file_data_en[3] = preg_replace('@%.*=(.*)$@', '\1', $file_content_en[$i]);
				unset($file_content_en[$i]);
				$i++;
			}
		}

		if (file_exists($wiki_file_es)) {
			$file_content_es = file($wiki_file_es);
			$file_comments_es = preg_grep('/^[%].*/', $file_content_es);
			$file_data_es = array();

			$i = 0;
			while (in_array($file_content_es[$i], $file_comments_es)) {
				if (strstr($file_content_es[$i], '% TITLE=')) $file_data_es[0] = preg_replace('@%.*=(.*)$@', '\1', $file_content_es[$i]);
				else if (strstr($file_content_es[$i], '% SUBTITLE=')) $file_data_es[1] = preg_replace('@%.*=(.*)$@', '\1', $file_content_es[$i]);
				else if (strstr($file_content_es[$i], '% DESCRIPTION=')) $file_data_es[2] = preg_replace('@%.*=(.*)$@', '\1', $file_content_es[$i]);
				else if (strstr($file_content_es[$i], '% KEYWORDS=')) $file_data_es[3] = preg_replace('@%.*=(.*)$@', '\1', $file_content_es[$i]);
				unset($file_content_es[$i]);
				$i++;
			}
		}

	}


?>

<style>
@import "/css/wiki_edition.css";
</style>

<script src="/js/wiki2html.js"></script>

<script src="/js/wiki_edition.js"></script>

<section id="content_edition">
<header>
	<hgroup>
		<h1>Edit</h1>
	</hgroup>
</header>

<article>

<?php

	if (isset($protected_file) || isset($no_parent)) {

?>

<p class="error">Sorry, you can not edit this file.</p>

<?php

		if (isset($protected_file)) {

?>

<p>It may be a system file. Remember users can only edit wiki files. Please, select a different one.</p>
<p>If you think this file should be edited, contact a developer or join the project and help us developing this website!</p>

<?php

		} else {

?>

<p>You are going too fast! Apparently, this page is orphan...</p>
<p>Please, <?php echo '<a href="./?page='.$dir.'/">edit its parent first!</a>'; ?></p>

<?php

		}

?>

<script>

	function forbidden_edition() {

		var main_nav = document.getElementById('main_nav');
		var r_aside = document.getElementById('r_aside');

		main_nav.style.display = 'none';
		r_aside.style.display = 'none';

		var parsed_content;

		parsed_content = '<header><hgroup><h1>#</h1><h2></h2></hgroup></header>';
		parsed_content += '<article><p class="centered extra_margin"><img src="/images/marx-brothers-doh.jpg" alt="marx-brothers-doh"></p></article>';
		parsed_content += '<footer><p class="section_title">#</p></footer>'
		document.getElementById('content').insertAdjacentHTML("afterBegin", parsed_content);

	}

	window.onload = forbidden_edition;

</script>

<?php

	} else {

		if (isset($cmd_output)) {

?>

<form class="wiki_edit_cmd">
	<textarea><?php foreach ($cmd_output as $line) echo "$line\n"; ?></textarea>
</form>

<?php

		}

?>

<form action="" method="post" class="wiki_edit">
	<div id="en_column">
		<h1>English</h1>
		<hr />
		<label for="form_title_en">Title: <span class="form_required" title="This field is required">*</span></label>
		<input name="title_en" id="form_title_en" type="text" required="required" value="<?php if (isset($file_data_en[0])) echo $file_data_en[0]; ?>" />
		<label for="form_subtitle_en">Subtitle:</label>
		<input name="subtitle_en" id="form_subtitle_en" type="text" value="<?php if (isset($file_data_en[1])) echo $file_data_en[1]; ?>" />
		<label for="form_description_en">Description: <span class="form_required" title="This field is required">*</span></label>
		<input name="description_en" id="form_description_en" type="text" required="required" value="<?php if (isset($file_data_en[2])) echo $file_data_en[2]; ?>" />
		<label for="form_keywords_en">Keywords: <span class="form_required" title="This field is required">*</span></label>
		<input name="keywords_en" id="form_keywords_en" type="text" required="required" value="<?php if (isset($file_data_en[3])) echo $file_data_en[3]; ?>" />
		<textarea name="wiki_content_en" id="form_wiki_content_en"><?php if (isset($file_content_en)) echo implode($file_content_en); ?></textarea>
	</div>
	<div id="es_column">
		<h1>Español</h1>
		<hr />
		<label for="form_title_es">Título: <span class="form_required" title="This field is required">*</span></label>
		<input name="title_es" id="form_title_es" type="text" required="required" value="<?php if (isset($file_data_es[0])) echo $file_data_es[0]; ?>" />
		<label for="form_subtitle_es">Subtítulo:</label>
		<input name="subtitle_es" id="form_subtitle_es" type="text" value="<?php if (isset($file_data_es[1])) echo $file_data_es[1]; ?>" />
		<label for="form_description_es">Descripción: <span class="form_required" title="This field is required">*</span></label>
		<input name="description_es" id="form_description_es" type="text" required="required" value="<?php if (isset($file_data_es[2])) echo $file_data_es[2]; ?>" />
		<label for="form_keywords_es">Palabras clave: <span class="form_required" title="This field is required">*</span></label>
		<input name="keywords_es" id="form_keywords_es" type="text" required="required" value="<?php if (isset($file_data_es[3])) echo $file_data_es[3]; ?>" />
		<textarea name="wiki_content_es" id="form_wiki_content_es"><?php if (isset($file_content_es)) echo implode($file_content_es); ?></textarea>
	</div>
	<input  type="hidden" name="type" value="wiki_form" />
	<input type="submit" value="Save" accesskey="x" />
</form>

<?php

	}

?>

</article>
<footer>
	<p class="section_title">Edit</p>
</footer>
</section>

<section id="content">
</section>

