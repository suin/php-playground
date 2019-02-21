<?php

declare(strict_types=1);

namespace Suin\Playground\BuilderPattern\No3ImmutableBuilder;

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

    /**
     * @test
     * @testdox EmailBuilderはイミュータブルである
     */
    public function immutability(): void
    {
        $builder1 = new EmailBuilder();
        $builder2 = $builder1->setFrom('alice@example.com');
        $builder3 = $builder1->setFrom('alice@example.com');
        self::assertEquals($builder2, $builder3);
        self::assertNotSame($builder2, $builder3);
        self::assertNotSame($builder1, $builder1->setTo('dummy@recipient'));
        self::assertNotSame($builder1, $builder1->setCc('dummy@recipient'));
        self::assertNotSame($builder1, $builder1->setSubject('dummy_subject'));
        self::assertNotSame($builder1, $builder1->setBody('dummy_body'));
    }

    /**
     * @test
     * @testdox EmailBuilderはイミュータブルなので再利用できる
     */
    public function builder_is_immutable_so_that_you_can_reuse_it(): void
    {
        // 1. Prepare preconfigured EmailBuilder:
        $emailTemplate = (new EmailBuilder())
            ->setFrom('webmaster@example.com')
            ->setSubject('Choose a new password')
            ->setBody(
                'Someone requested a new password for ... account.' .
                'Click here to reset your password: https://...' .
                "If you didn't make this request then you can safely ignore this email :)"
            );

        // 2. By reusing it you can build different emails:
        $aliceEml = $emailTemplate
            ->setTo('alice@example.com')
            ->setSubject('Please reset your password')
            ->build();
        $bobEml = $emailTemplate
            ->setTo('bob@example.com')
            ->build();

        // Built emails are actually different:
        self::assertSame('Please reset your password', $aliceEml->getSubject());
        self::assertSame('Choose a new password', $bobEml->getSubject());
        self::assertSame(['alice@example.com'], $aliceEml->getTo());
        self::assertSame(['bob@example.com'], $bobEml->getTo());
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
