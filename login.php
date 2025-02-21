<?php


if (!isset($_POST))
{
        $msg = "NO POST MESSAGE SET, Enter In your Password ";
        echo json_encode($msg);
        exit(0);
}
$request = $_POST;
$response = "unsupported request type, Please Try again";
switch ($request["type"])
{
        case "login":
                $response = "login, yeah we can do that";
        break;
}
echo json_encode($response);
exit(0);

?>
