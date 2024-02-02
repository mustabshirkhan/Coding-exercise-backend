<?php

namespace App\Exceptions;

class AlreadyPaidException extends \Exception
{
    public function __construct($message = "An error occurred.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
