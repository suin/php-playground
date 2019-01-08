<?php

declare(strict_types=1);

namespace Suin\Playground\CsvReadingModel;

interface CsvOpener
{
    public function open(string $filename): CsvOpenResult;
}

interface CsvOpenResult
{
    public function isOpened(): bool;

    public function getCsv(): Csv;

    public function getProblem(): string;
}

interface Rows
{
    /**
     * @return iterable|Row[]
     */
    public function getRows(): iterable;
}

interface Row
{
    public function getRowNumber(): int;

    /**
     * @return string[]
     */
    public function getColumns(): array;

    public function isEmpty(): bool;
}

final class SplFileObjectCsvOpener implements CsvOpener
{
    public function open(string $filename): CsvOpenResult
    {
        try {
            $file = new \SplFileObject($filename);
        } catch (\RuntimeException | \LogicException $e) {
            return new CsvOpenFailure($e->getMessage());
        }
        $file->setFlags(\SplFileObject::READ_CSV);
        return new CsvOpenSuccess(
            new Csv($filename, new SplFileObjectCsvRows($file))
        );
    }
}

final class SplFileObjectCsvRows implements Rows
{
    /**
     * @var \SplFileObject
     */
    private $fileObject;

    public function __construct(\SplFileObject $fileObject)
    {
        $this->fileObject = $fileObject;
    }

    /**
     * {@inheritdoc}
     */
    public function getRows(): iterable
    {
        $rowNumber = 1;

        foreach ($this->fileObject as $row) {
            yield $row === [null]
                ? new EmptyRow($rowNumber++)
                : new FilledRow($rowNumber++, ...$row);
        }
    }
}

final class CsvOpenSuccess implements CsvOpenResult
{
    /**
     * @var Csv
     */
    private $csv;

    public function __construct(Csv $csv)
    {
        $this->csv = $csv;
    }

    public function isOpened(): bool
    {
        return true;
    }

    public function getCsv(): Csv
    {
        return $this->csv;
    }

    public function getProblem(): string
    {
        throw new \LogicException('Unable to return a problem');
    }
}

final class CsvOpenFailure implements CsvOpenResult
{
    /**
     * @var string
     */
    private $problem;

    public function __construct(string $problem)
    {
        $this->problem = $problem;
    }

    public function isOpened(): bool
    {
        return false;
    }

    public function getCsv(): Csv
    {
        throw new \LogicException(
            'Unable to return CSV that could not be opened'
        );
    }

    public function getProblem(): string
    {
        return $this->problem;
    }
}

final class Csv
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var Rows
     */
    private $rows;

    public function __construct(string $filename, Rows $rows)
    {
        $this->filename = $filename;
        $this->rows = $rows;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return iterable|Row[]
     */
    public function readRows(): iterable
    {
        yield from $this->rows->getRows();
    }
}

final class EmptyRow implements Row
{
    /**
     * @var int
     */
    private $rowNumber;

    public function __construct(int $rowNumber)
    {
        $this->rowNumber = $rowNumber;
    }

    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    public function getColumns(): array
    {
        return [];
    }

    public function isEmpty(): bool
    {
        return true;
    }
}

final class FilledRow implements Row
{
    /**
     * @var int
     */
    private $rowNumber;

    /**
     * @var string[]
     */
    private $columns;

    public function __construct(
        int $rowNumber,
        string $column,
        string ...$columns
    ) {
        \array_unshift($columns, $column);
        $this->rowNumber = $rowNumber;
        $this->columns = $columns;
    }

    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function isEmpty(): bool
    {
        return false;
    }
}

$sampleData = new \SplFileObject(__DIR__ . '/test.csv', 'w');
$i = 0;
$sampleData->fputcsv([++$i, ++$i, ++$i]);
$sampleData->fputcsv([++$i, ++$i, ++$i]);
$sampleData->fputcsv([++$i, ++$i, ++$i]);
$sampleData->fputcsv([++$i, ++$i, ++$i]);

$opener = new SplFileObjectCsvOpener();
$openResult = $opener->open(__DIR__ . '/test2.csv');

if (!$openResult->isOpened()) {
    echo $openResult->getProblem(), \PHP_EOL;
} else {
    $csv = $openResult->getCsv();

    foreach ($csv->readRows() as $row) {
        \var_dump(
            $row->getRowNumber(),
            $row->getColumns(),
            $row->isEmpty()
        );
    }
}
