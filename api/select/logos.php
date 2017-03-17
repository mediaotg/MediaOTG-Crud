<?php
	
	//$logos = "{{name: 'one', age: 30 },{ name: 'two', age: 27 },{ name: 'three', age: 50 }}";

	$dir = "../../uploads/img/";

	$logos_arr = [];
	
	$di = new RecursiveDirectoryIterator($dir);
	foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
		if(!is_dir($filename) && !strpos($filename, '.DS_Store')){
	    	array_push($logos_arr, array("name"=>substr($filename, 14), "url"=>"image url"));
		}
	}
	//echo $logos;

	print_r(json_encode($logos_arr));
?>