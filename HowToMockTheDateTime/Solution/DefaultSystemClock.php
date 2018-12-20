<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Solution;

final class DefaultSystemClock implements SystemClock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
