<?php

declare(strict_types=1);

namespace Suin\Playground\HowToMockTheDateTime\Problem;

use PHPUnit\Framework\TestCase;

final class CouponIssuerTest extends TestCase
{
    public function test_issue_new_coupon(): void
    {
        self::markTestSkipped('このテストは絶対にPASSにならないデモです');

        $issuer = new CouponIssuer();
        $coupon = $issuer->issueNewCoupon();
        // マイクロ秒の差が生まれてテストがfailになる。
        self::assertEquals(new \DateTimeImmutable('+1 week'), $coupon->getExpirationDate());
    }
}
