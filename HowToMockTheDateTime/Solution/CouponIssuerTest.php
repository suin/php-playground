<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Solution;

use PHPUnit\Framework\TestCase;

final class CouponIssuerTest extends TestCase implements SystemClock
{
    public function test_issue_new_coupon(): void
    {
        // CouponIssuerはSystemClockをコンストラクタで受け取るようになったので、テストで
        // は、そのモックオブジェクトを渡すようにする。
        $issuer = new CouponIssuer($this->getSystemClock());
        $coupon = $issuer->issueNewCoupon();
        self::assertEquals(
            new \DateTimeImmutable('2018-01-08 00:00:00'), // 時刻を固定できるようになったので
                                                  // 期待する「クーポンの有効期限」は
                                                  // 好きな日時からの7日後にすることが
                                                  // できる。
            $coupon->getExpirationDate()
        );
    }

    /**
     * SystemClockインターフェイスの実装
     */
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2018-01-01 00:00:00');
    }

    /**
     * SystemClockのモックオブジェクトを返す
     */
    private function getSystemClock(): SystemClock
    {
        return $this;
    }
}
