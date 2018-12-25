<?php

declare(strict_types=1);

namespace Suin\Playground\PhpStormMetaExample;

final class SplCreator
{
    public static function create(string $name, ...$arguments)
    {
        $class = 'Spl' . $name;
        return $class(...$arguments);
    }
}
