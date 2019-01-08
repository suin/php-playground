<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObjectWithManyProperties\Mutable;

final class Product
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $colorCode;

    /**
     * @var string
     */
    private $sizeCode;

    public function __construct(
        string $name,
        string $description,
        int $price,
        string $colorCode,
        string $sizeCode
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->colorCode = $colorCode;
        $this->sizeCode = $sizeCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getColorCode(): string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): void
    {
        $this->colorCode = $colorCode;
    }

    public function getSizeCode(): string
    {
        return $this->sizeCode;
    }

    public function setSizeCode(string $sizeCode): void
    {
        $this->sizeCode = $sizeCode;
    }
}
