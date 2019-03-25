<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

interface HandCriteria
{
    public function isSatisfiedBy(FiveCards $fiveCards): bool;

    public function handDescriptor(): HandDescriptor;
}
