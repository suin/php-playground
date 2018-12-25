<?php

declare(strict_types=1);

namespace PHPSTORM_META {

    use Suin\Playground\PhpStormMetaExample\SplCreator;
    use Suin\Playground\PhpStormMetaExample\InstanceCreator;

    override(InstanceCreator::create(0), type(0));
    override(SplCreator::create(0), map([
        '' => 'Spl@',
    ]));
}
