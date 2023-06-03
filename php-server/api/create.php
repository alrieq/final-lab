<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}    


include_once '../db/Database.php';
include_once '../models/Bookmark.php';
$database = new Database();
$db = $database->connect();
$bookmark = new Bookmark($db);
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['title']) || !isset($data['link'])) {
    http_response_code(422);
    echo json_encode(array('message' => 'Missing parameters'));
    return;
}
$bookmark->setTitle($data['title']);
$bookmark->setLink($data['link']);
if($bookmark->create()){
    echo json_encode(array('message' => 'A bookmark has been added'));
}else {
    echo json_encode(array('message' => 'Error: no bookmark was created'));
}