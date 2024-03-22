<?php

namespace VendingMachine\Exception;

use Exception;
use VendingMachine\Interface\ExceptionBase;

class ErrorLoadProductsException extends Exception implements ExceptionBase
{
    protected $message = "Список продуктів пустий або пошкоджений";
}