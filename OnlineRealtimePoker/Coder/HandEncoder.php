<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Coder;

use Suin\Playground\OnlineRealtimePoker\Classifier\Hand;
use Suin\Playground\OnlineRealtimePoker\Classifier\HandDescriptor;

final class HandEncoder
{
    private const HANDS = [
        Hand\FourCards::NAME => '4K',
        Hand\FullHouse::NAME => 'FH',
        Hand\ThreeCards::NAME => '3K',
        Hand\TwoPairs::NAME => '2P',
        Hand\OnePair::NAME => '1P',
    ];

    public function encodeHand(HandDescriptor $hand): string
    {
        return (self::HANDS)[$hand->describeHand()] ?? '--';
    }
}
