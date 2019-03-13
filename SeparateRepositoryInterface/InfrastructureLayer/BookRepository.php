<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\InfrastructureLayer;

use Suin\Playground\SeparateRepositoryInterface\DomainLayer\Book;
use Suin\Playground\SeparateRepositoryInterface\DomainLayer\BookAdder;
use Suin\Playground\SeparateRepositoryInterface\DomainLayer\BookId;
use Suin\Playground\SeparateRepositoryInterface\DomainLayer\BookIdIssuer;

final class BookRepository implements BookIdIssuer, BookAdder
{
    /**
     * @var Book[]
     */
    private $books = [];

    public function issueBookIdentity(): BookId
    {
        return new BookId(\uniqid('book-', true));
    }

    public function addBook(Book $book): void
    {
        $this->books[$book->getBookId()->getId()] = $book;
    }
}
