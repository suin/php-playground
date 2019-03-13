<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\ApplicationLayer;

use Suin\Playground\SeparateRepositoryInterface\DomainLayer\Book;
use Suin\Playground\SeparateRepositoryInterface\DomainLayer\BookAdder;
use Suin\Playground\SeparateRepositoryInterface\DomainLayer\BookIdIssuer;

final class CreateNewBook
{
    /**
     * @var BookIdIssuer
     */
    private $bookIdIssuer;

    /**
     * @var BookAdder
     */
    private $bookAdder;

    public function __construct(
        BookIdIssuer $bookIdIssuer,
        BookAdder $bookAdder
    ) {
        $this->bookIdIssuer = $bookIdIssuer;
        $this->bookAdder = $bookAdder;
    }

    public function createNewBook(string $bookName): void
    {
        $book = new Book(
            $this->bookIdIssuer->issueBookIdentity(),
            $bookName
        );
        $this->bookAdder->addBook($book);
    }
}
