<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\DomainLayer;

final class Book
{
    /**
     * @var BookId
     */
    private $bookId;

    /**
     * @var string
     */
    private $bookName;

    public function __construct(BookId $bookId, string $bookName)
    {
        $this->bookId = $bookId;
        $this->bookName = $bookName;
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
