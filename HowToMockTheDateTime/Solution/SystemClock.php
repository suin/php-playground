<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Solution;

interface SystemClock
{
    public function now(): \DateTimeImmutable;
}
