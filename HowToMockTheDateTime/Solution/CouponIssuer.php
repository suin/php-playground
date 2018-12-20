<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Solution;

/**
 * クーポン発行サービス
 */
final class CouponIssuer
{
    /**
     * @var SystemClock
     */
    private $systemClock;

    public function __construct(SystemClock $systemClock)
    {
        $this->systemClock = $systemClock;
    }

    /**
     * 新しいクーポンを発行する
     */
    public function issueNewCoupon(): Coupon
    {
        return new Coupon($this->systemClock->now()->modify('+1 week')); // 有効期限が1週間のクーポン
    }
}
