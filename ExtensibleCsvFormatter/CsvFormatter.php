<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use Suin\Playground\ExtensibleCsvFormatter\QuotationRule\DefaultQuotationRules;

final class CsvFormatter
{
    /**
     * @var CsvOption
     */
    private $option;

    /**
     * @var QuotationRule
     */
    private $quotationRule;

    public function __construct(
        ?CsvOption $option = null,
        ?QuotationRule $quotationRule = null
    ) {
        $this->option = $option ?? new CsvOption();
        $this->quotationRule = $quotationRule ?? new DefaultQuotationRules();
    }

    public function format(string ...$record): string
    {
        return \implode(
                $this->delimiter(),
                $this->formatFields(...$record)
            ) . $this->newline();
    }

    /**
     * @return string[]
     */
    private function formatFields(string ...$fields): array
    {
        $formattedFields = [];

        foreach ($fields as $field) {
            $formattedFields[] = $this->formatField($field);
        }
        return $formattedFields;
    }

    private function formatField(string $field): string
    {
        return $this->fieldNeedsQuotes($field)
            ? $this->quoteField($field)
            : $field;
    }

    private function fieldNeedsQuotes(string $field): bool
    {
        return $this->quotationRule->fieldNeedsQuotes($field, $this->option);
    }

    private function quoteField(string $field): string
    {
        return $this->enclosure()
            . $this->escapeEnclosure($field)
            . $this->enclosure();
    }

    private function escapeEnclosure(string $field): string
    {
        return \str_replace(
            $this->enclosure(),
            $this->enclosure() . $this->enclosure(),
            $field
        );
    }

    private function delimiter(): string
    {
        return $this->option->getDelimiter();
    }

    private function enclosure(): string
    {
        return $this->option->getEnclosure();
    }

    private function newline(): string
    {
        return $this->option->getNewline();
    }
}
