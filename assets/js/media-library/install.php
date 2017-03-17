<?php
	// Install Media Library Plugin
	if (isset($_POST['pluginLoc'])){
		$pluginLocation = $_POST['pluginLoc'];
		$pluginLocation2 = $_POST['pluginLoc'];
		$back = substr_count($pluginLocation2, '/') + 1;
		$newDir = 'pluginLocation.php';
		for($i = 0; $i<$back; $i++){
			$newDir = '../'.$newDir;
		}
		$myfile = fopen($newDir, "w") or die("Unable to open file!");
		$txt = "<?php echo '".$pluginLocation."'; ?>";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Install Media Library</title>
	</head>
	<body>
		<h1>Set up Media Library Plugin</h1>
		<?php if(!isset($_POST['pluginLoc']) ){?>
			<form action="install.php" method="post">
				<input type="text" name="pluginLoc" />
				<input type="submit" />
			</form>
		<?php } else {?>
			<p>Your plugin is located at: <?php echo $pluginLocation; ?>.Back <?php echo $newDir; ?></p>
			<p>You can use the plugin in your application now. Just add the class '.media-library' to a text input element, and instantiate the mediaLibrary function.</p>
		<?php } ?>
	</body>
</html>