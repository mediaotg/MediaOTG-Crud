<?php
	include_once '../../config/database.php';
	include_once '../objects/project.php';

	$database = new Database();
	$db = $database->getConnection();

	$project = new Project($db);
	$data = json_decode(file_get_contents("php://input"));
	$project->id = $data->id;
	$project->name = $data->name;
	$project->content = $data->content;
	$project->thumbnail = $data->thumbnail;
	$project->logo = $data->logo;
	$project->gallery = $data->gallery;

	if($project->update()){
		echo "Project was updated.";
	}

	else{
		echo "Unable to update project.";
	}
?>