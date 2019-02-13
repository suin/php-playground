<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No1Basic;

use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function email_builder_usage(): void
    {
        // 1. create EmailBuilder object.
        $emailBuilder = new EmailBuilder();

        // 2. provide email properties.
        $emailBuilder->setFrom('alice@example.com');
        $emailBuilder->setTo('bob@example.com');
        $emailBuilder->setCc('carol@example.com');
        $emailBuilder->setSubject('Hello');
        $emailBuilder->setBody('Hello, Bob.');

        // 3. get Email object with calling build() method.
        $email = $emailBuilder->build();

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
        $emailBuilder = new EmailBuilder();
        $emailBuilder->setFrom('dummy@sender');
        $emailBuilder->setCc('bob@example.com');
        $emailBuilder->setSubject('dummy_subject');
        $emailBuilder->setBody('dummy_body');
        $email = $emailBuilder->build();
        self::assertSame([], $email->getTo());
        self::assertSame(['bob@example.com'], $email->getCc());
    }

    public function test_missing_sender_email_address(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'At least one from-address must be provided'
        );
        $emailBuilder = new EmailBuilder();
        $emailBuilder->setCc('dummy@address');
        $emailBuilder->setSubject('dummy_subject');
        $emailBuilder->setBody('dummy_body');
        $emailBuilder->build();
    }

    public function test_missing_recipient_email_address(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'At least one recipient address (To or CC) must be provided'
        );
        $emailBuilder = new EmailBuilder();
        $emailBuilder->setFrom('dummy@address');
        $emailBuilder->setSubject('dummy_subject');
        $emailBuilder->setBody('dummy_body');
        $emailBuilder->build();
    }

    public function test_missing_subject(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Email subject must be provided');
        $emailBuilder = new EmailBuilder();
        $emailBuilder->setFrom('dummy@address');
        $emailBuilder->setTo('dummy@address');
        $emailBuilder->setBody('dummy_body');
        $emailBuilder->build();
    }

    public function test_missing_body(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Email body must be provided');
        $emailBuilder = new EmailBuilder();
        $emailBuilder->setFrom('dummy@address');
        $emailBuilder->setTo('dummy@address');
        $emailBuilder->setSubject('dummy_subject');
        $emailBuilder->build();
    }
}
