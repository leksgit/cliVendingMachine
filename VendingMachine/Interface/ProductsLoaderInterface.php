<?php

namespace VendingMachine\Interface;

use VendingMachine\Exception\ErrorLoadProductsException;

interface ProductsLoaderInterface
{

    /**
     * Load From source products data
     * @return array
     * @throws ErrorLoadProductsException
     */
    public function loadProducts(): array;

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function addNewProducts(ProductInterface $product): bool;
}