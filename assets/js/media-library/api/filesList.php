<?php
	// Get Files in folder

	$dir = '../'.$_POST['dir'];
	$contentsArr = [];
	$filesArr = [];
	$foldersArr = [];

	// if file exists, get contents
	if (file_exists($dir)){
		$contentsArr = array_diff(scandir($dir), array('.', '..', '.DS_Store'));
	} else {
		mkdir($dir);
		$contentsArr = array_diff(scandir($dir), array('.', '..', '.DS_Store'));
	}

	foreach($contentsArr as $value){
		if(is_dir($dir.'/'.$value)){
			array_push($foldersArr, $value);
		} else {
			array_push($filesArr, $value);
		}
	}

	$contentsArr = array('folders' => $foldersArr, 'files' => $filesArr);

	echo json_encode($contentsArr);
?>	