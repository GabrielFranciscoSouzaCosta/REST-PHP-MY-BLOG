<?php

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: PUT');

	header('Access-Controll-Allow-Headers: Access-Controll-Allow-Headers,
	Content-Type,Access-Controll-Allow-Methods,Authorization,X-Requested-with');

	include_once '../../config/Database.php';
	include_once '../../models/Category.php';

	$database = new Database();
	$db = $database->connect();

	$category = new Category($db);

	$data = json_decode(file_get_contents("php://input"));

	$category->id			= $data->id;
	$category->name			= $data->name;

	if($category->update())
	{
		echo json_encode(
			array(
				'message' => 'Category Updated'
			)
		);
	}
	else
	{
		echo json_encode(
			array(
				'message' => 'Category Not Updated'
			)
		);
	}