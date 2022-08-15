<?php 
require_once('vendor/autoload.php');

echo getallheaders()['token'];


echo $_ENV["REGION"];
?>