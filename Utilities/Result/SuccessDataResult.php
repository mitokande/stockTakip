<?php
namespace Utilities\Result;

class SuccessDataResult extends DataResult
{
    public function __construct($data, $message)
    {
        parent::__construct($data, $message,true);
    }
}