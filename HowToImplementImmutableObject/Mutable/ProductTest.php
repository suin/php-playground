<?php

declare(strict_types=1);

namespace Suin\Playground\HowToImplementImmutableObject\Mutable;

use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_change_price(): void
    {
        $product = new Product(100);
        self::assertSame(100, $product->getPrice());

        // mutate
        $product->setPrice(300);
        self::assertSame(300, $product->getPrice());
    }
}
