<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No2FluentInterface;

use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function email_builder_usage(): void
    {
        $email = (new EmailBuilder())
            ->setFrom('alice@example.com')
            ->setTo('bob@example.com')
            ->setCc('carol@example.com')
            ->setSubject('Hello')
            ->setBody('Hello, Bob.')
            ->build();

        // The Email object will be like the following:
        self::assertSame(['alice@example.com'], $email->getFrom());
        self::assertSame(['bob@example.com'], $email->getTo());
        self::assertSame(['carol@example.com'], $email->getCc());
        self::assertSame('Hello', $email->getSubject());
        self::assertSame('Hello, Bob.', $email->getBody());
    }

    /**
     * @test
     * @testdox buildするには少なくともToかCCどちらかにメールアドレスがあれば良い
     */
    public function build_email_without_to(): void
    {
        $email = (new EmailBuilder())
            ->setFrom('dummy@sender')
            ->setCc('bob@example.com')
            ->setSubject('dummy_subject')
            ->setBody('dummy_body')
            ->build();
        self::assertSame([], $email->getTo());
        self::assertSame(['bob@example.com'], $email->getCc());
    }

    public function test_missing_sender_email_address(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'At least one from-address must be provided'
        );
        (new EmailBuilder())
            ->setCc('dummy@address')
            ->setSubject('dummy_subject')
            ->setBody('dummy_body')
            ->build();
    }

    public function test_missing_recipient_email_address(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'At least one recipient address (To or CC) must be provided'
        );
        (new EmailBuilder())
            ->setFrom('dummy@address')
            ->setSubject('dummy_subject')
            ->setBody('dummy_body')
            ->build();
    }

    public function test_missing_subject(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Email subject must be provided');
        (new EmailBuilder())
            ->setFrom('dummy@address')
            ->setTo('dummy@address')
            ->setBody('dummy_body')
            ->build();
    }

    public function test_missing_body(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Email body must be provided');
        (new EmailBuilder())
            ->setFrom('dummy@address')
            ->setTo('dummy@address')
            ->setSubject('dummy_subject')
            ->build();
    }
}
