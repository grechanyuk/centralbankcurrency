<?php

namespace Grechanyuk\CentralBankCurrency\Facades;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Facade;

/**
 * @method static convert(string $isoCode, int $amount)
 * @method static currencyByDay(Carbon $date)
 * @method static getCurrenciesList()
 * @method static clearCache()
 */
class CentralBankCurrency extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'centralbankcurrency';
    }
}
