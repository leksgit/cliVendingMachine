<?php

namespace VendingMachine\Interface;

use VendingMachine\Product;

interface TransactionInterface
{
    /**
     * Show list available coins
     * @return array
     */
    public function getCoinsList(): array;

    /**
     * Check if coin is allowed to make payment
     * @param float $check
     * @return bool
     */
    public function checkAllowedCoin(float $check): bool;

    /**
     * Add coin from user
     * @param float $add
     * @return bool
     */
    public function addUserCoin(float $add): bool;

    /**
     * Check if already buyer add need coins for buy product
     * @return bool
     */
    public function checkIfAlreadyHasNeedCoinsForProduct(): bool;

    /**
     * Set product for check need sum of coins and calculate return sum
     * @param Product $product
     * @return bool
     */
    public function setProductCostForBuy(Product $product): bool;

    /**
     * Return array with coins need to return buyer
     * @return array
     */
    public function returnCoins(): array;

    /**
     * Reset info about process transactions
     * @return void
     */
    public function resetSelectedProduct():void;

    /**
     * check if we need make return coin
     * @return bool
     */
    public function checkNeedReturn():bool;
}