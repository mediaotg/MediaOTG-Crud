<?php
	include_once '../../config/database.php';
	include_once '../objects/project.php';

	$database = new Database();
	$db = $database->getConnection();

	$project = new Project($db);
	$data = json_decode(file_get_contents("php://input"));
	$project->id = $data->id;
	$project->readOne();

	$project_arr[] = array(
		"id" => $project->id,
		"name" => $project->name,
		"content" => $project->content,
		"thumbnail" => $project->thumbnail, 
		"logo" => $project->logo, 
		"gallery" => $project->gallery
	);

	print_r(json_encode($project_arr));

?>