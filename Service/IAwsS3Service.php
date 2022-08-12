<?php
require 'vendor/autoload.php';
require_once("Utilities/UUID/UUID.php");
require_once("Utilities/Result/DataResult.php");
interface IAwsS3Service
{
    function Upload($tempFileLocation) : DataResult;
/*$file_name = $_FILES['image']['name'];
$temp_file_location = $_FILES['image']['tmp_name'];*/
}