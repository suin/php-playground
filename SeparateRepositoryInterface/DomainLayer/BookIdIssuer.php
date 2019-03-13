<?php

declare(strict_types=1);

namespace Suin\Playground\SeparateRepositoryInterface\DomainLayer;

interface BookIdIssuer
{
    public function issueBookIdentity(): BookId;
}
