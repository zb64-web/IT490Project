#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Database connection settings (VM2 MySQL)
$DB_HOST = '192.168.1.20';  // Replace with your Database Server's IP
$DB_USER = 'remoteuser';
$DB_PASS = 'securepassword';
$DB_NAME = 'starterdb';

function doLogin($username, $password)
{
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if ($conn->connect_error) {
        return ["error" => "Database connection failed"];
    }

    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if (password_verify($password, $hashedPassword)) {
        return ["success" => true, "message" => "Login successful"];
    } else {
        return ["success" => false, "message" => "Invalid credentials"];
    }
}

function requestProcessor($request)
{
    echo "Received request:\n";
    var_dump($request);

    if (!isset($request['type'])) {
        return ["error" => "Unsupported message type"];
    }

    switch ($request['type']) {
        case "login":
            return doLogin($request['username'], $request['password']);
        case "validate_session":
            return ["message" => "Session validation not implemented"];
        default:
            return ["error" => "Unknown request type"];
    }
}

$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

echo "RabbitMQ Authentication Server Running...\n";
$server->process_requests('requestProcessor');

?>
