<?php
namespace Utilities\Result;

require_once("Utilities/Result/Result.php");
class SuccessResult extends Result
{
    public function __construct($message)
    {
        parent::__construct($message,true);
    }
}