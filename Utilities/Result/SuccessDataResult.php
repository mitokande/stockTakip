<?php
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
class SuccessDataResult extends DataResult
{
    public function __construct($data, $message)
    {
        parent::__construct($data, $message,true);
    }
}