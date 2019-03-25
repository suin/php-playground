<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use Suin\Playground\OnlineRealtimePoker\Classifier\HandCriteria;
use Suin\Playground\OnlineRealtimePoker\Classifier\HandDescriptor;

abstract class AbstractHand implements HandCriteria, HandDescriptor
{
    final public function handDescriptor(): HandDescriptor
    {
        return $this;
    }
}
