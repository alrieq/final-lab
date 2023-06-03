<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}



include_once '../db/Database.php';
include_once '../models/Bookmark.php';
$database = new Database();
$db = $database->connect();
$bookmark = new Bookmark($db);

$result = $bookmark->readAll();
if (! empty($result)){
    echo json_encode($result);
}else {
    http_response_code(404);
    echo json_encode(array('message' => 'No bookmarks where found'));
    return;
}