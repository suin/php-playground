<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No1Basic;

final class Email
{
    /**
     * @var string[]
     */
    private $from;

    /**
     * @var string[]
     */
    private $to;

    /**
     * @var string[]
     */
    private $cc;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @param string[] $from
     * @param string[] $to
     * @param string[] $cc
     */
    public function __construct(
        array $from,
        array $to,
        array $cc,
        string $subject,
        string $body
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * @return string[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * @return string[]
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return string[]
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
