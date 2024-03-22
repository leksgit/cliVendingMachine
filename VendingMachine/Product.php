<?php

namespace VendingMachine;

use VendingMachine\Interface\ProductInterface;

class Product implements ProductInterface
{

    public function __construct(
        public int $id,
        public string $name,
        public float $price
    ) {
    }
}