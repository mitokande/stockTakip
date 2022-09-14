<?php
require_once("vendor/autoload.php");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
function awsUploadPhoto()
{
    echo json_encode($_FILES);
    exit();
    $file_name = $_FILES['image']['name'];
    $temp_file_location = $_FILES['image']['tmp_name'];
    $factory = \Utilities\DependencyResolver\AbstractFactory\Factory::getInstance();
    $result = $factory->createFileService()->Upload($file_name,$temp_file_location);
    return json_encode($result);
}
