<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObject\Immutable;

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

    public function setPrice(int $price): self
    {
        return new self($price);
    }
}
