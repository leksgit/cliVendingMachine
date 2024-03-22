<?php
namespace VendingMachine;

use VendingMachine\Exception\WrongCoinException;
use VendingMachine\Interface\TransactionInterface;

class Transaction implements TransactionInterface
{
    private float $productCost = 0;
    private float $coinsAdded = 0;
    private const ALLOWED_COINS = [
        '0.01',
        '0.05',
        '0.10',
        '0.25',
        '0.50',
        '1.00',
    ];

    #[\Override] public function getCoinsList(): array
    {
        return self::ALLOWED_COINS;
    }

    #[\Override] public function checkAllowedCoin(float $check): bool
    {
        return (in_array($check, self::ALLOWED_COINS));
    }

    /**
     * @throws WrongCoinException
     */
    #[\Override] public function addUserCoin(float $add): bool
    {
        if ($this->checkAllowedCoin($add)){
            return (bool)$this->coinsAdded += $add;
        }
        throw new WrongCoinException();
    }

    #[\Override] public function checkIfAlreadyHasNeedCoinsForProduct(): bool
    {
        return ($this->coinsAdded >= $this->productCost);
    }

    #[\Override] public function setProductCostForBuy(Product $product): bool
    {
        $this->productCost = $product->price;
        return boolval($this->productCost);
    }

    #[\Override] public function returnCoins(): array
    {
        $restOfCoinsArray = [];
        $restOfCoins = intval(($this->coinsAdded - $this->productCost) * 100);

        $reversCoins = array_reverse(self::ALLOWED_COINS);
        while ($restOfCoins > 0) {
            foreach ($reversCoins as $coin) {
                $coinCalc = intval($coin * 100);
                if ($restOfCoins >= $coinCalc ) {
                    $restOfCoins = $restOfCoins - $coinCalc;
                    $restOfCoinsArray[] = $coin;
                }
            }
        }
        return $restOfCoinsArray;
    }

    #[\Override] public function checkNeedReturn(): bool
    {
        return $this->coinsAdded > $this->productCost ;
    }

    public function notMatch(): float
    {
        return $this->productCost - $this->coinsAdded;
    }

    #[\Override] public function resetSelectedProduct(): void
    {
        $this->productCost = 0;
        $this->coinsAdded = 0;
    }
}