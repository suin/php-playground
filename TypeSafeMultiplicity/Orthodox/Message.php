<?php

declare(strict_types=1);

namespace Suin\Playground\TypeSafeMultiplicity\Orthodox;

final class Message
{
    /**
     * @var Recipient[]
     */
    private $recipients;

    /**
     * @param Recipient[] $recipients
     */
    public function __construct(array $recipients)
    {
        if (\count($recipients) < 1) {
            throw new \InvalidArgumentException(
                'Recipients must be at least one'
            );
        }

        foreach ($recipients as $recipient) {
            if (!$recipient instanceof Recipient) {
                throw new \InvalidArgumentException(
                    'Element of $recipients must be instance of Recipient'
                );
            }
        }

        $this->recipients = $recipients;
    }
}
