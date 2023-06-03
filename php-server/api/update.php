<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}



include_once '../db/Database.php';
include_once '../models/Bookmark.php';
$database = new Database();
$db = $database->connect();
$bookmark = new Bookmark($db);

$data = json_decode(file_get_contents('php://input'));

if(!$data || !$data->id || !$data->title){
    http_response_code(422);
    echo json_encode(array('message' => 'Missing parameters'));
    return;
}
$bookmark->setId($data->id);
$bookmark->setTitle($data->title);

if($bookmark->update()){
    echo json_encode(
        array('message' => 'The bookmark was updated')
    );
}else{
    echo json_encode(
        array('message' => 'The bookmark was NOT updated')
    );
}