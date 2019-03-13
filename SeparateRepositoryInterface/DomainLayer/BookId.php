<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\DomainLayer;

final class BookId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
