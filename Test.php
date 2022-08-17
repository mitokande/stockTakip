<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers:  Origin, X-Requested-With, Content-Type, Accept, Authorization');
print_r(getallheaders()["Token"]);
exit();
?>