<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObject\Immutable;

use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_change_price(): void
    {
        $product1 = new Product(100);
        self::assertSame(100, $product1->getPrice());

        $product2 = $product1->setPrice(300);
        self::assertSame(100, $product1->getPrice());
        self::assertSame(300, $product2->getPrice());
    }
}
