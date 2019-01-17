<?php

declare(strict_types=1);

namespace Suin\Playground\TypeSafeMultiplicity\TypeSafe;

final class Profile
{
    /**
     * @var Hobby[]
     */
    private $hobbies;

    public function setHobbies(
        Hobby $hobby1,
        Hobby $hobby2,
        Hobby $hobby3,
        Hobby ...$hobbies
    ): void {
        $this->hobbies = \func_get_args();
    }

    /**
     * @return Hobby[]
     */
    public function getHobbies(): array
    {
        return $this->hobbies;
    }
}
