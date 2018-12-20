<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Problem;

/**
 * クーポン発行サービス
 */
final class CouponIssuer
{
    /**
     * 新しいクーポンを発行する
     */
    public function issueNewCoupon(): Coupon
    {
        return new Coupon(new \DateTimeImmutable('+1 week')); // 有効期限が1週間のクーポン
    }
}
