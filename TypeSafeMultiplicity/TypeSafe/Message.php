<?php

declare(strict_types=1);

namespace Suin\Playground\TypeSafeMultiplicity\TypeSafe;

final class Message
{
    /**
     * @var Recipient[]
     */
    private $recipients;

    public function __construct(Recipient $recipient, Recipient ...$recipients)
    {
        \array_unshift($recipients, $recipient);
        $this->recipients = $recipients;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
