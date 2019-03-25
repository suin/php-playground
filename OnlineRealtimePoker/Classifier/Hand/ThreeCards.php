<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class ThreeCards extends AbstractHand
{
    public const NAME = 'ThreeCards';

    public function isSatisfiedBy(FiveCards $fiveCards): bool
    {
        return $fiveCards->countCardsGroupingByRank() === [1, 1, 3];
    }

    public function describeHand(): string
    {
        return self::NAME;
    }
}
