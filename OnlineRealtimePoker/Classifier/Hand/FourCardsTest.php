<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier\Hand;

use PHPUnit\Framework\TestCase;
use Suin\Playground\OnlineRealtimePoker\Classifier\Card;
use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class FourCardsTest extends TestCase
{
    /**
     * @test
     * @dataProvider satisfiablePatterns
     */
    public function satisfaction(FiveCards $satisfiablePattern): void
    {
        $handCriteria = new FourCards();
        self::assertTrue($handCriteria->isSatisfiedBy($satisfiablePattern));
    }

    /**
     * @test
     * @dataProvider unsatisfiablePatterns
     */
    public function unsatisfaction(FiveCards $unsatisfiablePattern): void
    {
        $handCriteria = new FourCards();
        self::assertFalse($handCriteria->isSatisfiedBy($unsatisfiablePattern));
    }

    public function satisfiablePatterns(): iterable
    {
        return [
            [self::fiveCard(2, 1, 1, 1, 1)],
            [self::fiveCard(1, 2, 1, 1, 1)],
            [self::fiveCard(1, 1, 2, 1, 1)],
            [self::fiveCard(1, 1, 1, 2, 1)],
            [self::fiveCard(1, 1, 1, 1, 2)],
        ];
    }

    public function unsatisfiablePatterns(): iterable
    {
        yield 'full house' => [self::fiveCard(1, 1, 1, 2, 2)];
        yield 'three cards' => [self::fiveCard(1, 1, 1, 2, 3)];
        yield 'two pairs' => [self::fiveCard(1, 1, 2, 2, 3)];
        yield 'one pair' => [self::fiveCard(1, 1, 2, 3, 4)];
        yield 'all cards are different' => [self::fiveCard(1, 2, 3, 4, 5)];
    }

    private static function fiveCard(
        int $rank1,
        int $rank2,
        int $rank3,
        int $rank4,
        int $rank5
    ): FiveCards {
        return new FiveCards(
            new Card($rank1),
            new Card($rank2),
            new Card($rank3),
            new Card($rank4),
            new Card($rank5)
        );
    }
}
