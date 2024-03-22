<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$vendingMachine = new VendingLogic();

$vendingMachine->showProductList();

while (true) {
    $needId = readline("Оберіть Бажаний продукт вказавши його ID або Х щоб завершити: ");

    if (in_array($needId, ['x', 'X', 'х', 'Х'])) {
        die();
    }

    if (is_int(intval($needId))) {
        $vendingMachine->selectProduct($needId);
        if ($vendingMachine->selectedProductsExist) {
            $vendingMachine->showAllowedCoins();
            while ($vendingMachine->selectedProductsExist) {
                $coins = readline('Монета: ');
                $vendingMachine->addCoins($coins);
            }
        }
    }
}
