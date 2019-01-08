<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObjectWithManyProperties\Immutable1;

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
        return new self(
            $name,
            $this->description,
            $this->price,
            $this->colorCode,
            $this->sizeCode
        );
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        return new self(
            $this->name,
            $description,
            $this->price,
            $this->colorCode,
            $this->sizeCode
        );
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        return new self(
            $this->name,
            $this->description,
            $price,
            $this->colorCode,
            $this->sizeCode
        );
    }

    public function getColorCode(): string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): self
    {
        return new self(
            $this->name,
            $this->description,
            $this->price,
            $colorCode,
            $this->sizeCode
        );
    }

    public function getSizeCode(): string
    {
        return $this->sizeCode;
    }

    public function setSizeCode(string $sizeCode): self
    {
        return new self(
            $this->name,
            $this->description,
            $this->price,
            $this->colorCode,
            $sizeCode
        );
    }
}
