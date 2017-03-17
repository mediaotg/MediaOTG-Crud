<?php
	// config and object
	include_once '../../config/database.php';
	include_once '../objects/project.php';

	// db connect
	$database = new Database();
	$db = $database->getConnection();

	$project = new Project($db);
	$data = json_decode(file_get_contents("php://input"));
	$project->name = $data->name;
	$project->content = $data->content;
	$project->thumbnail = $data->thumbnail;
	$project->logo = $data->logo;
	$project->gallery = $data->gallery;
	$project->created = date('Y-m-d H:i:s');

	if ($project->create()){
		echo "Project was created.";
	}
	else{
		echo "Unabel to create project.";
	}
?>