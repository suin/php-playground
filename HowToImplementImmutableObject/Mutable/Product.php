<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObject\Mutable;

final class Product
{
    /**
     * @var int
     */
    private $price;

    public function __construct(int $price)
    {
        $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}
