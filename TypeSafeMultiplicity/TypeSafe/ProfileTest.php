<?php

declare(strict_types=1);

namespace Suin\Playground\TypeSafeMultiplicity\TypeSafe;

use PHPUnit\Framework\TestCase;

final class ProfileTest extends TestCase
{
    public function test_set_hobbies(): void
    {
        $profile = new Profile();
        $hobbies = [new Hobby(), new Hobby(), new Hobby(), new Hobby()];
        $profile->setHobbies(...$hobbies);
        self::assertSame($hobbies, $profile->getHobbies());
    }
}
