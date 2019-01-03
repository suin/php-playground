<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 支払い承認済み
 */
final class Approved extends PaymentStatus
{
    public function isCompleted(): bool
    {
        return false;
    }
}
