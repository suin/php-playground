<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

use Suin\Playground\ExtensibleCsvFormatter\CsvOption;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

final class DefaultQuotationRules implements QuotationRule
{
    /**
     * @var QuotationRules
     */
    private $rules;

    public function __construct()
    {
        $this->rules = new QuotationRules(
            new ContainsEnclosure(),
            new ContainsDelimiter(),
            new ContainsNewline(),
            new ContainsWhitespace()
        );
    }

    public function fieldNeedsQuotes(string $field, CsvOption $option): bool
    {
        return $this->rules->fieldNeedsQuotes($field, $option);
    }
}
