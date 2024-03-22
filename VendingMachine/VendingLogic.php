<?php

namespace VendingMachine;

use VendingMachine\Exception\ErrorLoadProductsException;
use VendingMachine\Exception\WrongProductIdException;
use VendingMachine\Interface\ProductsLoaderInterface;
use VendingMachine\Interface\VendingLogicInterface;

class VendingLogic implements VendingLogicInterface
{
    public array $products;
    public ?Product $selectedProduct;
    public bool $selectedProductsExist = false;

    /**
     * @throws ErrorLoadProductsException
     */
    #[\Override] public function loadProducts(ProductsLoaderInterface $loader): void
    {
        $products = $loader->loadProducts();
        foreach ($products as $product) {
            $this->products[$product['id']] = new Product(
                id: $product['id'],
                name: $product['name'],
                price: $product['price'],
            );
        }
    }

    #[\Override] public function selectProduct(int $productId): Product
    {
        if (!isset($this->products[$productId])) {
            throw  new WrongProductIdException();
        }

        $this->selectedProduct = $this->products[$productId];

        $this->selectedProductsExist = true;

        return $this->selectedProduct;
    }

    #[\Override] public function productsForSell(): array
    {
        return $this->products;
    }


    #[\Override] public function resetSelectedProduct(): void
    {
        $this->selectedProduct = null;
        $this->selectedProductsExist = false;
    }
}