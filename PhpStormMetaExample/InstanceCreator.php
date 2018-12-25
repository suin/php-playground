<?php

declare(strict_types=1);

namespace Suin\Playground\PhpStormMetaExample;

final class InstanceCreator
{
    /**
     * @return object
     */
    public static function create(string $class)
    {
        return new $class();
    }
}
