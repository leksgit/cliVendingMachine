<?php
namespace VendingMachine;

class OutputHandler
{
    /**
     * Display single message.
     *
     * @param string $message
     */
    public function displayMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }

    /**
     * Display list of products.
     *
     * @param array $products
     */
    public function displayProductList(array $products): void
    {
        foreach ($products as $product) {
            $this->displaySingleProduct($product);
        }
    }

    public function displaySingleProduct(Product $product): void
    {
        $this->displayMessage("Id: {$product->id} Назва: {$product->name}  Вартість {$product->price}");
    }

    /**
     * Display list of allowed coins.
     *
     * @param array $coins An array of allowed coin denominations.
     */
    public function displayAllowedCoins(array $coins): void
    {
        $this->displayMessage("Allowed coins: " . implode(', ', $coins));
    }
}
