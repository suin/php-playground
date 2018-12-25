<?php

/** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Suin\Playground\PhpStormMetaExample;

final class ClientCode
{
    public function main(): void
    {
        $dateTime = InstanceCreator::create(\DateTimeImmutable::class);
        $dateTime->format('Y-m-d');

        $doublyLinkedList = SplCreator::create('DoublyLinkedList');
        $doublyLinkedList->top();
    }
}
