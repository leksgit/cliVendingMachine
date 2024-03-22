<?php

require_once __DIR__ . '/vendor/autoload.php';

use VendingMachine\InputHandler;
use VendingMachine\Interface\ExceptionBase;
use VendingMachine\JsonProductLoader;
use VendingMachine\OutputHandler;
use VendingMachine\Transaction;
use VendingMachine\VendingLogic;

$input = new InputHandler();
$output = new OutputHandler();
$coins = new Transaction();

$productLoader = new JsonProductLoader();

$vendingMachine = new VendingLogic();

$vendingMachine->loadProducts($productLoader);

$output->displayMessage('Список продукті');

$output->displayProductList($vendingMachine->products);


while (true) {
    $needId = $input->getInput("Оберіть Бажаний продукт вказавши його ID або Х щоб завершити: ");

    if (in_array($needId, ['x', 'X', 'х', 'Х'])) {
        $output->displayMessage("Дякуемо що скористалися нашими послугами!");
        break;
    }

    if (is_numeric($needId)) {
        try {
            $product = $vendingMachine->selectProduct($needId);

            $output->displaySingleProduct($product);

            $coins->setProductCostForBuy(product: $product);
            if ($vendingMachine->selectedProductsExist) {

                $output->displayMessage("Внесіть монети для оплати, доступні монети:");
                $output->displayMessage(implode('; ', $coins->getCoinsList()));

                while (!$coins->checkIfAlreadyHasNeedCoinsForProduct()) {
                    $userCoin = $input->getInput('Монета: ');
                    try {
                        $coins->addUserCoin(floatval(str_replace(',', '.', $userCoin)));
                        if (!$coins->checkIfAlreadyHasNeedCoinsForProduct()) {
                            $output->displayMessage("Не вистачае: " . $coins->notMatch());
                        }
                    } catch (Exception $exception) {
                        $output->displayMessage("Недопустима монета!");
                        $output->displayMessage(implode('; ', $coins->getCoinsList()));
                    }
                }
                $output->displayMessage("================");
                $output->displayMessage("Отримайте Ваш товар");
                $output->displaySingleProduct($product);
                if ($coins->checkNeedReturn()) {
                    $restOfCoins = $coins->returnCoins();
                    $output->displayMessage("Решта: " . implode(', ', $restOfCoins));
                }

                $output->displayMessage("Дякуемо за покупку!");
                $output->displayMessage("================");

                $vendingMachine->resetSelectedProduct();
                $coins->resetSelectedProduct();

                $output->displayProductList($vendingMachine->products);
                $output->displayMessage("================");
            }
        } catch (ExceptionBase $e) {
            $output->displayMessage($e->getMessage());
        }
    } else {
        $output->displayMessage("Упс... Спробуйте ще раз!");
    }
}
