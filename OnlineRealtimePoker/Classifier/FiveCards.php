<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

final class FiveCards
{
    /**
     * @var Card[]
     */
    private $cards;

    public function __construct(
        Card $card1,
        Card $card2,
        Card $card3,
        Card $card4,
        Card $card5
    ) {
        $this->cards = [$card1, $card2, $card3, $card4, $card5];
    }

    public function countCardsGroupingByRank(): array
    {
        $cardCountsByRank = [];

        foreach ($this->cards as $card) {
            if (!\array_key_exists($card->rank(), $cardCountsByRank)) {
                $cardCountsByRank[$card->rank()] = 0;
            }
            $cardCountsByRank[$card->rank()]++;
        }

        $cardCountsByRank = \array_values($cardCountsByRank);

        \sort($cardCountsByRank);

        return $cardCountsByRank;
    }
}
