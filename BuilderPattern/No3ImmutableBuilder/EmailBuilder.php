<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No3ImmutableBuilder;

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

    public function setFrom(string ...$from): self
    {
        return $this->copy('from', $from);
    }

    public function setTo(string ...$to): self
    {
        return $this->copy('to', $to);
    }

    public function setCc(string ...$cc): self
    {
        return $this->copy('cc', $cc);
    }

    public function setSubject(string $subject): self
    {
        return $this->copy('subject', $subject);
    }

    public function setBody(string $body): self
    {
        return $this->copy('body', $body);
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

    private function copy(string $key, $value): self
    {
        $new = clone $this;
        $new->{$key} = $value;
        return $new;
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
