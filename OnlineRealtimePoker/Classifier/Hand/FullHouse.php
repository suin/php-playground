<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class FullHouse extends AbstractHand
{
    public const NAME = 'FullHouse';

    public function isSatisfiedBy(FiveCards $fiveCards): bool
    {
        return $fiveCards->countCardsGroupingByRank() === [2, 3];
    }

    public function describeHand(): string
    {
        return self::NAME;
    }
}
