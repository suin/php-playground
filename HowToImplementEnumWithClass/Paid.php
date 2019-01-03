<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 支払い済み
 */
final class Paid extends PaymentStatus
{
    public function isCompleted(): bool
    {
        return true;
    }
}
