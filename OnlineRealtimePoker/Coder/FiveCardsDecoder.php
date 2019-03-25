<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Coder;

use RuntimeException;
use Suin\Playground\OnlineRealtimePoker\Classifier\Card;
use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;

final class FiveCardsDecoder
{
    /**
     * @throws RuntimeException
     */
    public function decode(string $fiveCardsCode): FiveCards
    {
        $rankChars = $this->parseRanks($fiveCardsCode);
        // todo: check if the size of rankChars is five.
        $cards = $this->mapRankCharsToCards($rankChars);
        return new FiveCards(...$cards);
    }

    /**
     * @throws RuntimeException
     *
     * @return string[]
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    private function parseRanks(string $fiveCards): array
    {
        \preg_match_all('/[DCHS](?<rank>[0-9AJQK]{1,2})/', $fiveCards, $matches);

        if (!\array_key_exists('rank', $matches)) {
            throw new RuntimeException("Parse error: {$fiveCards}");
        }
        return $matches['rank'];
    }

    /**
     * @param string[] $rankChars
     *
     * @throws RuntimeException
     *
     * @return Card[]
     */
    private function mapRankCharsToCards(array $rankChars): array
    {
        $cards = [];

        foreach ($rankChars as $rankChar) {
            $cards[] = $this->mapRankCharToCard($rankChar);
        }
        return $cards;
    }

    /**
     * @throws RuntimeException
     */
    private function mapRankCharToCard(string $rankChar): Card
    {
        switch ($rankChar) {
            case 'A':
                return new Card(1);
            case 'J':
                return new Card(11);
            case 'Q':
                return new Card(12);
            case 'K':
                return new Card(13);
            case 2 <= $rankChar && $rankChar <= 10:
                return new Card((int) $rankChar);
        }

        throw new RuntimeException("Unexpected rank: {$rankChar}");
    }
}
