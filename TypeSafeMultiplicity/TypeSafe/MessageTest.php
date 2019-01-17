<?php

declare(strict_types=1);

namespace Suin\Playground\TypeSafeMultiplicity\TypeSafe;

use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function test_constructor(): void
    {
        $recipients = [new Recipient(), new Recipient()];
        $message = new Message(...$recipients);
        self::assertSame($recipients, $message->getRecipients());
    }
}
