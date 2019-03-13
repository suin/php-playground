<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

use Suin\Playground\ExtensibleCsvFormatter\CsvOption;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

final class ContainsNewline implements QuotationRule
{
    public function fieldNeedsQuotes(string $field, CsvOption $option): bool
    {
        return \strpos($field, "\r") !== false
            || \strpos($field, "\n") !== false;
    }
}
