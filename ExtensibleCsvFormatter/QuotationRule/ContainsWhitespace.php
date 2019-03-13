<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

use Suin\Playground\ExtensibleCsvFormatter\CsvOption;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

final class ContainsWhitespace implements QuotationRule
{
    public function fieldNeedsQuotes(string $field, CsvOption $option): bool
    {
        return \preg_match('/\s/', $field) > 0;
    }
}
