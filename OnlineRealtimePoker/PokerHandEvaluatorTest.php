<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker;

use PHPUnit\Framework\TestCase;

final class PokerHandEvaluatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider fiveCards
     */
    public function evaluate_hand(string $fiveCards, string $expectedHand): void
    {
        $actualHand = (new PokerHandEvaluator())->evaluateHand($fiveCards);
        self::assertSame($expectedHand, $actualHand);
    }

    public function fiveCards(): iterable
    {
        return[
            ['D3C3C10D10S3', 'FH'],
            ['S8D10HJS10CJ', '2P'],
            ['DASAD10CAHA', '4K'],
            ['S10HJDJCJSJ', '4K'],
            ['S10HAD10DAC10', 'FH'],
            ['HJDJC3SJS3', 'FH'],
            ['S3S4H3D3DA', '3K'],
            ['S2HADKCKSK', '3K'],
            ['SASJDACJS10', '2P'],
            ['S2S10H10HKD2', '2P'],
            ['CKH10D10H3HJ', '1P'],
            ['C3D3S10SKS2', '1P'],
            ['S3SJDAC10SQ', '--'],
            ['C3C9SAS10D2', '--'],
        ];
    }
}
