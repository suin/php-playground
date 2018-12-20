<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Problem;

use DateTime;

final class Coupon
{
    /**
     * @var DateTime
     */
    private $expirationDate;

    /**
     * @param DateTime $expirationDate クーポンの有効期限
     */
    public function __construct(\DateTimeImmutable $expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    public function getExpirationDate(): \DateTimeImmutable
    {
        return $this->expirationDate;
    }
}
