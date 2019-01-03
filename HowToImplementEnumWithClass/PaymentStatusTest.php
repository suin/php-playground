<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

use PHPUnit\Framework\TestCase;

/**
 * 支払状況のテストコード
 */
final class PaymentStatusTest extends TestCase
{
    public function test_pending_should_be_different_from_other_status(): void
    {
        self::assertDifference(
            PaymentStatus::pending(),
            ...[
                PaymentStatus::approved(),
                PaymentStatus::rejected(),
                PaymentStatus::paid(),
            ]
        );
    }

    public function test_approved_should_be_different_form_other_status(): void
    {
        self::assertDifference(
            PaymentStatus::approved(),
            ...[
                PaymentStatus::pending(),
                PaymentStatus::rejected(),
                PaymentStatus::paid(),
            ]
        );
    }

    public function test_rejected_should_be_different_from_other_status(): void
    {
        self::assertDifference(
            PaymentStatus::rejected(),
            ...[
                PaymentStatus::pending(),
                PaymentStatus::approved(),
                PaymentStatus::paid(),
            ]
        );
    }

    public function test_paid_should_be_different_form_other_status(): void
    {
        self::assertDifference(
            PaymentStatus::paid(),
            ...[
                PaymentStatus::pending(),
                PaymentStatus::approved(),
                PaymentStatus::rejected(),
            ]
        );
    }

    public function test_pending_should_be_incompleted_state(): void
    {
        self::assertFalse(PaymentStatus::pending()->isCompleted());
    }

    public function test_approved_should_be_incompleted_state(): void
    {
        self::assertFalse(PaymentStatus::approved()->isCompleted());
    }

    public function test_rejected_should_be_completed_state(): void
    {
        self::assertTrue(PaymentStatus::rejected()->isCompleted());
    }

    public function test_paid_should_be_completed_state(): void
    {
        self::assertTrue(PaymentStatus::paid()->isCompleted());
    }

    private static function assertDifference(
        PaymentStatus $status1,
        PaymentStatus $status2,
        PaymentStatus $status3,
        PaymentStatus $status4
    ): void {
        self::assertThat(
            $status1,
            self::logicalAnd(
                self::logicalNot(self::equalTo($status2)),
                self::logicalNot(self::equalTo($status3)),
                self::logicalNot(self::equalTo($status4))
            )
        );
    }
}
