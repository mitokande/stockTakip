<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');require_once("Service/AwsS3Manager.php");
function awsUploadPhoto(){
    $file_name = $_FILES['image']['name'];
    $temp_file_location = $_FILES['image']['tmp_name'];

   $service =  new AwsS3Manager();
   $result = $service->Upload($file_name,$temp_file_location);
    return json_encode($result);
}
