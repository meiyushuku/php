<?php

$json_file = file_get_contents('/volume1/require/youtube_mirror/confidential.json');
$json_data = json_decode($json_file, true);

$host = $json_data['host'];
$port = $json_data['port'];
$dbname = $json_data['dbname'];
$dbn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$user = $json_data['user'];
$password = $json_data['password'];

try {
    $connect = new PDO($dbn, $user, $password);
    //echo "Successfully!\n";
} catch (PDOException $e) {
    echo $e->getMessage() . "\n";
    exit();
}
