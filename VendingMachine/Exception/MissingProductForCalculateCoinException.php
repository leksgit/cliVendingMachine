<?php

namespace VendingMachine\Exception;

use Exception;
use VendingMachine\Interface\ExceptionBase;

class MissingProductForCalculateCoinException extends Exception implements ExceptionBase
{
    protected $message = "Не обран продукт для придбання!";
}