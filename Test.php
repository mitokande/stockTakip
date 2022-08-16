<?php 
require_once('vendor/autoload.php');

echo getallheaders()['Token'];


echo $_ENV["REGION"];
?>