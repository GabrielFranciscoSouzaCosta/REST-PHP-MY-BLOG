<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';

	$database = new Database();
	$db = $database->connect();

	$category = new Category($db);

	$result = $category->read();

	$num = $result->rowCount();

	if($num > 0)
	{
		$category_arr = array('data' => array());
		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			$categoryItem = array(
				'id' => $id,
				'name' => $name
			);
			array_push($category_arr['data'], $categoryItem);
		}

		echo json_encode($category_arr);
	}
	else
	{
		echo json_encode(array('message' => 'No Categories found'));
	}