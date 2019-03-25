<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class FourCards extends AbstractHand
{
    public const NAME = 'FourCards';

    public function isSatisfiedBy(FiveCards $fiveCards): bool
    {
        return $fiveCards->countCardsGroupingByRank() === [1, 4];
    }

    public function describeHand(): string
    {
        return self::NAME;
    }
}
