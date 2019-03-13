<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

use Suin\Playground\ExtensibleCsvFormatter\CsvOption;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule;

final class QuotationRules implements QuotationRule
{
    /**
     * @var QuotationRule[]
     */
    private $quotationRules;

    public function __construct(QuotationRule ...$quotationRules)
    {
        $this->quotationRules = $quotationRules;
    }

    public function fieldNeedsQuotes(string $field, CsvOption $option): bool
    {
        foreach ($this->quotationRules as $quotationRule) {
            if ($quotationRule->fieldNeedsQuotes($field, $option)) {
                return true;
            }
        }
        return false;
    }
}
