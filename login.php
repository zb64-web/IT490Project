<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

if (!isset($_POST['uname']) || !isset($_POST['pword'])) {
    echo json_encode(["error" => "Missing username or password"]);
    exit();
}

$username = $_POST['uname'];
$password = $_POST['pword'];

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

$request = array();
$request['type'] = "login";  
$request['username'] = $username;
$request['password'] = $password;

$response = $client->send_request($request);

echo json_encode($response);
?>
