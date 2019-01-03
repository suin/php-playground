<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementEnumWithClass;

/**
 * 支払状況
 */
abstract class PaymentStatus
{
    /**
     * Enumオブジェクトは、このクラスの静的メソッドからのみ作られることを保証するために、コン
     * ストラクタの可視性はprivateにする。
     */
    private function __construct()
    {
    }

    /**
     * 「保留」の状況を表すオブジェクトを返す
     */
    public static function pending(): Pending
    {
        return new Pending();
    }

    /**
     * 「承認済み」の状況を表すオブジェクトを返す
     */
    public static function approved(): Approved
    {
        return new Approved();
    }

    /**
     * 「支払い却下」の状況を表すオブジェクトを返す
     */
    public static function rejected(): Rejected
    {
        return new Rejected();
    }

    /**
     * 「支払い済み」の状況を表すオブジェクトを返す
     */
    public static function paid(): Paid
    {
        return new Paid();
    }

    /**
     * 支払い済みもしくは支払い却下になったか
     */
    abstract public function isCompleted(): bool;
}
