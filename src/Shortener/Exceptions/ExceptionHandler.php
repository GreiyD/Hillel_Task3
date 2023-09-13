<?php

namespace App\Shortener\Exceptions;

use Exception;

class ExceptionHandler extends Exception
{
    /**
     * @param string $message
     */
    public function __construct($message = "")
{
    parent::__construct($message);
}
}