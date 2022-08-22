<?php
require_once("ApiConfig.php");


function cloneStockForm($jotformAPI)
{
    $result = $jotformAPI->cloneForm("222202437411037");
    return $result['id'];
}

function cloneOrderForm($jotformAPI)
{
    $result = $jotformAPI->cloneForm("222211450234035");
    return $result['id'];
}


function insertStockFormID($jotformAPI, $submissionID, $stockFormID)
{
    $result = $jotformAPI->editSubmission($submissionID, array(
        "3" => $stockFormID,
    ));
    return $result;
}

function insertOrderFormID($jotformAPI, $submissionID, $orderFormID)
{
    $result = $jotformAPI->editSubmission($submissionID, array(
        "4" => $orderFormID,
    ));
    return $result;
}


?>