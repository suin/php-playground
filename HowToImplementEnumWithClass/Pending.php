<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 保留
 */
final class Pending extends PaymentStatus
{
    public function isCompleted(): bool
    {
        return false;
    }
}
