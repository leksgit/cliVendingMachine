<?php

namespace VendingMachine\Exception;

use Exception;
use VendingMachine\Interface\ExceptionBase;

class WrongProductIdException extends Exception implements ExceptionBase
{
    protected $message = "Обраного id не існуе!";
}