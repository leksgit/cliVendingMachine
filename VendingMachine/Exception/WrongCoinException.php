<?php

namespace VendingMachine\Exception;

use Exception;
use VendingMachine\Interface\ExceptionBase;

class WrongCoinException extends Exception implements ExceptionBase
{
    protected $message = "Недопустима монета!";
}