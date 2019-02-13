<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No1Basic;

final class EmailBuilder
{
    /**
     * @var string[]
     */
    private $from = [];

    /**
     * @var string[]
     */
    private $to = [];

    /**
     * @var string[]
     */
    private $cc = [];

    /**
     * @var null|string
     */
    private $subject;

    /**
     * @var null|string
     */
    private $body;

    public function setFrom(string ...$from): void
    {
        $this->from = $from;
    }

    public function setTo(string ...$to): void
    {
        $this->to = $to;
    }

    public function setCc(string ...$cc): void
    {
        $this->cc = $cc;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function build(): Email
    {
        $this->assertAtLeastOneFromAddress();
        $this->assertAtLeastOneRecipientAddress();
        $this->assertSubjectIsProvided();
        $this->assertThatBodyIsSpecified();
        return new Email(
            $this->from,
            $this->to,
            $this->cc,
            $this->subject,
            $this->body
        );
    }

    private function assertAtLeastOneFromAddress(): void
    {
        if (empty($this->from)) {
            throw new \LogicException(
                'At least one from-address must be provided'
            );
        }
    }

    private function assertAtLeastOneRecipientAddress(): void
    {
        if (empty($this->to) && empty($this->cc)) {
            throw new \LogicException(
                'At least one recipient address (To or CC) must be provided'
            );
        }
    }

    private function assertSubjectIsProvided(): void
    {
        if ($this->subject === null) {
            throw new \LogicException('Email subject must be provided');
        }
    }

    private function assertThatBodyIsSpecified(): void
    {
        if ($this->body === null) {
            throw new \LogicException('Email body must be provided');
        }
    }
}
