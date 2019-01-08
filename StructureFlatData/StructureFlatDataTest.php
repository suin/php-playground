<?php

declare(strict_types=1);

namespace Suin\Playground\StructureFlatData;

use PHPUnit\Framework\TestCase;

final class StructureFlatDataTest extends TestCase
{
    /**
     * @test
     */
    public function demo(): void
    {
        self::assertSame(
            [
                'name' => 'product1',
                'size' => [
                    'S' => ['H' => '20', 'W' => '30', 'D' => '40'],
                    'M' => ['H' => '50', 'W' => '60', 'D' => '70'],
                ],
            ],
            $this->structure(
                [
                    'name' => 'product1',
                    'size.S.H' => '20',
                    'size.S.W' => '30',
                    'size.S.D' => '40',
                    'size.M.H' => '50',
                    'size.M.W' => '60',
                    'size.M.D' => '70',
                ]
            )
        );
    }

    private function structure(array $data): array
    {
        $shapes = [];

        foreach ($data as $key => $value) {
            $nestedKeys = \explode('.', $key);

            foreach (\array_reverse($nestedKeys) as $nestedKey) {
                $value = [$nestedKey => $value];
            }
            $shapes[] = $value;
        }
        return \array_merge_recursive(...$shapes);
    }
}
