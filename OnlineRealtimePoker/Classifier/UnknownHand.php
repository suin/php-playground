<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

final class UnknownHand implements HandDescriptor
{
    public function describeHand(): string
    {
        return 'UnknownHand';
    }
}
