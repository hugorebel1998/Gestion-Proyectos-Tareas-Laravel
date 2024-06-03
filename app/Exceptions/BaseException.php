<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $error;
    protected $httpCode = 500;
}
