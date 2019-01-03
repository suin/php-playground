<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 支払い却下
 */
final class Rejected extends PaymentStatus
{
    public function isCompleted(): bool
    {
        return true;
    }
}
