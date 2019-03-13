<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

interface QuotationRule
{
    public function fieldNeedsQuotes(string $field, CsvOption $option): bool;
}
