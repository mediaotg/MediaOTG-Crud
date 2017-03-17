<?php
	$files = json_decode($_POST['files']);

	foreach ($files as $value) {
		unlink('../'.$value);
	}
?>