<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 支払状況
 */
final class PaymentStatus
{
    private const PENDING = 0;

    private const APPROVED = 1;

    private const REJECTED = 2;

    private const PAID = 3;

    /**
     * @var int
     */
    private $status;

    /**
     * Enumオブジェクトは、このクラスの静的メソッドからのみ作られることを保証するために、コン
     * ストラクタの可視性はprivateにする。
     */
    private function __construct(int $status)
    {
        $this->status = $status;
    }

    /**
     * 「保留」の状況を表すオブジェクトを返す
     */
    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    /**
     * 「承認済み」の状況を表すオブジェクトを返す
     */
    public static function approved(): self
    {
        return new self(self::APPROVED);
    }

    /**
     * 「支払い却下」の状況を表すオブジェクトを返す
     */
    public static function rejected(): self
    {
        return new self(self::REJECTED);
    }

    /**
     * 「支払い済み」の状況を表すオブジェクトを返す
     */
    public static function paid(): self
    {
        return new self(self::PAID);
    }

    /**
     * 支払い済みもしくは支払い却下になったか
     */
    public function isCompleted(): bool
    {
        return $this->status === self::REJECTED
            || $this->status === self::PAID;
    }
}
