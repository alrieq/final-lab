<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: *');
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
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

if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(array('message' => 'Missing parameters'));
    return;
}
$bookmark->setId($data->id);

if($bookmark->delete()){
    echo json_encode(
        array('message' => 'The bookmark was deleted')
    );
}else{
    echo json_encode(
        array('message' => 'The bookmark was NOT deleted')
    );
}