<?php

declare(strict_types = 1);

namespace App\DTO;

class Money
{
    public function __construct(
        private float $money
    ) { }

    public function getMoney(): float
    {
        return $this->money;
    }

    public function getMoneyWithPesoCurrencySign(): string
    {
        return '₱' . $this->money;
    }
}