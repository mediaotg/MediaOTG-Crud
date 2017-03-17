<?php
	header("Access-Control-Allow-Origin: *");
	header("Conent-Type: application/json; charset=UTF-8");

	include_once '../../config/database.php';
	include_once '../objects/project.php';

	// db
	$database = new Database();
	$db = $database->getConnection();

	$project = new Project($db);

	$stmt = $project->readAll();
	$num = $stmt->rowCount();

	// if records found
	if ($num>0){
		$x = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$subarr[] = array(
				"id" => $id,
				"name" => $name,
				"content" => $content,
				"thumbnail" => $thumbnail,
				"logo" => str_replace('FILE: ', ' ', html_entity_decode($logo)),
				"gallery" => $gallery
			);
			json_encode($subarr);
		}
	}

	print_r(json_encode($subarr));
?>