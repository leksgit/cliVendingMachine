<?php

namespace VendingMachine\Interface;

use VendingMachine\Exception\WrongProductIdException;
use VendingMachine\Product;

interface VendingLogicInterface
{
    /**
     * Load products from source
     * @param ProductsLoaderInterface $loader
     * @return void
     */
    public function loadProducts(ProductsLoaderInterface $loader):void;


    /**
     * Select product by id
     * @param int $productId
     * @return Product
     * @throws WrongProductIdException
     */
    public function selectProduct(int $productId):Product;


    /**
     * Get list available products
     * @return array
     */
    public function productsForSell():array;

    /**
     * @return void
     */
    public function resetSelectedProduct():void;
}