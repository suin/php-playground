<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

interface HandDescriptor
{
    public function describeHand(): string;
}
