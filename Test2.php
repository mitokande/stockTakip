<?php
require_once ("Controllers/OrderController.php");

clientCode();
function clientCode()
{
    $s1 = OrderController::getInstance();
    echo $s1->sayHello();
    return;
    if ($s1 === $s2) {
        echo "Singleton works, both variables contain the same instance.";
    } else {
        echo "Singleton failed, variables contain different instances.";
    }
}