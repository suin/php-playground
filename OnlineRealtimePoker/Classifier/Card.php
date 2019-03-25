<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

use InvalidArgumentException;

final class Card
{
    /**
     * @var int
     */
    private $rank;

    public function __construct(int $rank)
    {
        self::assertRankRange($rank);
        $this->rank = $rank;
    }

    public function rank(): int
    {
        return $this->rank;
    }

    private static function assertRankRange(int $rank): void
    {
        if ($rank < 0 || 13 < $rank) {
            throw new InvalidArgumentException(
                "Card rank must be between 0 and 13 but {$rank} is given"
            );
        }
    }
}
