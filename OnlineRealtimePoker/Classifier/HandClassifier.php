<?php

declare(strict_types=1);

namespace Suin\Playground\OnlineRealtimePoker\Classifier;

use Suin\Playground\OnlineRealtimePoker\Classifier\Hand\FourCards;
use Suin\Playground\OnlineRealtimePoker\Classifier\Hand\FullHouse;
use Suin\Playground\OnlineRealtimePoker\Classifier\Hand\OnePair;
use Suin\Playground\OnlineRealtimePoker\Classifier\Hand\ThreeCards;
use Suin\Playground\OnlineRealtimePoker\Classifier\Hand\TwoPairs;

final class HandClassifier
{
    /**
     * @var HandCriteria[]
     */
    private $hands;

    public function __construct()
    {
        $this->hands = [
            new FourCards(),
            new FullHouse(),
            new ThreeCards(),
            new TwoPairs(),
            new OnePair(),
        ];
    }

    public function classify(FiveCards $fiveCards): HandDescriptor
    {
        foreach ($this->hands as $hand) {
            if ($hand->isSatisfiedBy($fiveCards)) {
                return $hand->handDescriptor();
            }
        }
        return new UnknownHand();
    }
}
