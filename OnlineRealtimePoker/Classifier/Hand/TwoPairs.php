<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class TwoPairs extends AbstractHand
{
    public const NAME = 'TwoPairs';

    public function isSatisfiedBy(FiveCards $fiveCards): bool
    {
        return $fiveCards->countCardsGroupingByRank() === [1, 2, 2];
    }

    public function describeHand(): string
    {
        return self::NAME;
    }
}
