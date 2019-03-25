<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker;

use Suin\Playground\OnlineRealtimePoker\Classifier\FiveCards;
use Suin\Playground\OnlineRealtimePoker\Classifier\HandClassifier;
use Suin\Playground\OnlineRealtimePoker\Classifier\HandDescriptor;
use Suin\Playground\OnlineRealtimePoker\Coder\FiveCardsDecoder;
use Suin\Playground\OnlineRealtimePoker\Coder\HandEncoder;

final class PokerHandEvaluator
{
    public function evaluateHand(string $fiveCardsCode): string
    {
        $fiveCards = $this->decode($fiveCardsCode);
        $hand = $this->classifyHand($fiveCards);
        return $this->encode($hand);
    }

    private function decode(string $fiveCardsCode): FiveCards
    {
        return (new FiveCardsDecoder())->decode($fiveCardsCode);
    }

    private function classifyHand(FiveCards $fiveCards): HandDescriptor
    {
        return (new HandClassifier())->classify($fiveCards);
    }

    private function encode(HandDescriptor $handDescriptor): string
    {
        return (new HandEncoder())->encodeHand($handDescriptor);
    }
}
