<?php
namespace Pmp\Domain\Model\Quote;

interface QuoteRepository
{
    public function quoteWithKey(Key $key);

    public function add(Quote $quote);
}