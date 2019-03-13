<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\DomainLayer;

interface BookAdder
{
    public function addBook(Book $book): void;
}
