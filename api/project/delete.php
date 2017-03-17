<?php
	include_once '../../config/database.php';
	include_once '../objects/project.php';

	$database = new Database();
	$db = $database->getConnection();

	$project = new Project($db);
	$data = json_decode(file_get_contents("php://input"));
	$project->id = $data->id;

	if($project->delete()){
		echo "Project was deleted.";
	} else {
		echo "Unable to delete object.";
	}
?>