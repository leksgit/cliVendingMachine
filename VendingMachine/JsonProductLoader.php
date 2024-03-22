<?php

namespace VendingMachine;

use Exception;
use VendingMachine\Exception\ErrorLoadProductsException;
use VendingMachine\Interface\ProductInterface;

class JsonProductLoader implements Interface\ProductsLoaderInterface
{

    /**
     * Load products from json file
     * @throws ErrorLoadProductsException
     */
    #[\Override] public function loadProducts($file = 'products.json'): array
    {
        try {
            return json_decode(file_get_contents($file), true);
        } catch (Exception) {
            throw new ErrorLoadProductsException();
        }
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function addNewProducts(ProductInterface $product): bool
    {
        // TODO: Implement addNewProducts() method.
    }
}