<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObjectWithManyProperties\Immutable2;

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

    public function setName(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $new = clone $this;
        $new->description = $description;
        return $new;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $new = clone $this;
        $new->price = $price;
        return $new;
    }

    public function getColorCode(): string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): self
    {
        $new = clone $this;
        $new->colorCode = $colorCode;
        return $new;
    }

    public function getSizeCode(): string
    {
        return $this->sizeCode;
    }

    public function setSizeCode(string $sizeCode): self
    {
        $new = clone $this;
        $new->sizeCode = $sizeCode;
        return $new;
    }
}
