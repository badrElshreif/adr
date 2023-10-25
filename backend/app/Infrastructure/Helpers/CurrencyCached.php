<?php

namespace App\Infrastructure\Helpers;

use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\Cache;

class CurrencyCached
{
    /**
     * @var array currency rates
     */
    protected array $rates;

    /**
     * @var string cache key
     */
    protected string $cacheKey = 'currency-rates';

    /**
     * @param int|null $cacheTtl
     */
    public function __construct(int $cacheTtl = null)
    {
        $ttl         = $cacheTtl ?? config('app.cache_ttl.currency');
        $this->rates = Cache::remember($this->cacheKey, $ttl, function ()
        {
            return Currency::rates()->latest()->get();
        });
    }

    /**
     * Currency conversion.
     *
     * @param float $amount
     * @param string $toCurrency
     * @param string $fromCurrency
     * @return float|int
     */
    public function convert(float $amount, string $toCurrency, string $fromCurrency)
    {
        return $amount * $this->rates[$toCurrency] / $this->rates[$fromCurrency];
    }
}
