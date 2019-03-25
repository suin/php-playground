<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Coder;

use PHPUnit\Framework\TestCase;
use Suin\Playground\OnlineRealtimePoker\Classifier\Card;
use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class FiveCardsDecoderTest extends TestCase
{
    /**
     * @test
     * @dataProvider validFiveCardsCodes
     */
    public function successfully_decodes(
        string $validFiveCardsCode,
        FiveCards $expectedOutput
    ): void {
        $actualOutput = (new FiveCardsDecoder())->decode($validFiveCardsCode);
        self::assertEquals($expectedOutput, $actualOutput);
    }

    public function validFiveCardsCodes(): iterable
    {
        return [
            ['D3C3C10D10S3', self::fiveCard(3, 3, 10, 10, 3)],
            ['S8D10HJS10CJ', self::fiveCard(8, 10, 11, 10, 11)],
            ['DASAD10CAHA', self::fiveCard(1, 1, 10, 1, 1)],
            ['S10HJDJCJSJ', self::fiveCard(10, 11, 11, 11, 11)],
            ['S10HAD10DAC10', self::fiveCard(10, 1, 10, 1, 10)],
            ['HJDJC3SJS3', self::fiveCard(11, 11, 3, 11, 3)],
            ['S3S4H3D3DA', self::fiveCard(3, 4, 3, 3, 1)],
            ['S2HADKCKSK', self::fiveCard(2, 1, 13, 13, 13)],
            ['SASJDACJS10', self::fiveCard(1, 11, 1, 11, 10)],
            ['S2S10H10HKD2', self::fiveCard(2, 10, 10, 13, 2)],
            ['CKH10D10H3HJ', self::fiveCard(13, 10, 10, 3, 11)],
            ['C3D3S10SKS2', self::fiveCard(3, 3, 10, 13, 2)],
            ['S3SJDAC10SQ', self::fiveCard(3, 11, 1, 10, 12)],
            ['C3C9SAS10D2', self::fiveCard(3, 9, 1, 10, 2)],
        ];
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
