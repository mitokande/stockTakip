<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
print_r(getallheaders()["Token"]);
exit();
?>