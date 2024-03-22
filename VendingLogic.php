<?php

class VendingLogic
{
    const ALLOWED_COINS = [
        '0.01',
        '0.05',
        '0.10',
        '0.25',
        '0.50',
        '1.00',
    ];
    public bool $selectedProductsExist = false;
    private array $products;
    private ?array $selectedProduct = [];
    private float $addingCoins = 0;

    public function __construct()
    {
        $this->getProductsFromJson();
    }

    private function getProductsFromJson(): void
    {
        try {
            $products = json_decode(file_get_contents('products.json'), true);
        } catch (Exception $exception) {
            $this->P("Список продуктів пустий або пошкоджений");
        }

        foreach ($products as $product) {
            $this->products[$product['id']] = $product;
        }
    }

    private function P($echo)
    {
        echo $echo . PHP_EOL;
    }

    public function selectProduct(int $id = null): void
    {
        if (!isset($this->products[$id])) {
            $this->P("Такого товару не існуе, оберіть будьласка інший!");
            return;
        }

        $this->selectedProduct = $this->products[$id];

        $this->selectedProductsExist = true;
        $this->P('Ви обрали:');
        $this->showSingleLineProduct($this->selectedProduct);
    }

    private function showSingleLineProduct(array $product): void
    {
        if (isset($product['id'])) {
            $this->P("Id: " . $product['id'] . " Назва: " . $product['name'] . " Вартість " . $product['price']);
        }
    }

    public function addCoins(false|string $coins): void
    {
        $coins = str_replace(',', '.', $coins);
        if (!in_array($coins, self::ALLOWED_COINS)) {
            $this->P("Недопустима монета!");
            $this->showAllowedCoins();
            return;
        }

        $this->addingCoins += $coins;
        if ($this->addingCoins >= $this->selectedProduct['price']) {
            $this->P("================");
            $this->P("Отримайте Ваш товар");
            $this->showSingleLineProduct($this->selectedProduct);

            if ($this->addingCoins > $this->selectedProduct['price']) {
                $this->returnCoins();
            }
            $this->P("Дякуемо за покупку!");
            $this->P("================");
            $this->resetSelectedProduct();
            $this->showProductList();
            $this->P("================");
        } else {
            $this->P("Не вистачае: " . $this->selectedProduct['price'] - $this->addingCoins);
        }
    }

    public function showAllowedCoins(): void
    {
        $this->P("Внесіть монети для оплати, доступні монети:");
        $this->P(implode('; ', self::ALLOWED_COINS));
    }

    private function returnCoins(): void
    {
        $restOfCoins = $this->addingCoins - $this->selectedProduct['price'];
        $this->P("Решта: " . $restOfCoins);
        $this->P("Монети решти: ");
        while (true) {
            foreach (array_reverse(self::ALLOWED_COINS) as $coin) {
                if ($restOfCoins <= 0) {
                    return;
                }
                if ($restOfCoins < $coin) {
                    continue;
                } else {
                    $this->P($coin);
                    $restOfCoins = -$coin;
                }
            }
        }
    }

    private function resetSelectedProduct(): void
    {
        $this->selectedProduct = null;
        $this->selectedProductsExist = false;
    }

    public function showProductList(): void
    {
        $this->P('Список продукті');
        foreach ($this->products as $product) {
            $this->showSingleLineProduct($product);
        }
    }


}

