<?php

namespace Grechanyuk\CentralBankCurrency;

use Grechanyuk\CentralBankCurrency\Utils\Currency;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use \Grechanyuk\CentralBankCurrency\Models\CentralBankCurrency as CentralBankCurrencyModel;

class CentralBankCurrency
{
    /**
     * @param string $needCurrency
     * ISO Code
     * @param float $amount
     * Amount to convert
     * @param bool $reverse
     * Revers converting. Eg. USD to RUB
     * @return float|null
     */

    public function convert(string $needCurrency, float $amount, bool $reverse = false): ?float
    {
        $currencies = $this->getCurrenciesList();

        $currency = $currencies->where('iso_code', $needCurrency)->first();

        if(!$currency) {
            $currency = $currencies->where('iso_code', config('centralbankcurrency.defaultISO', 'USD'))->first();

            if(!$currency) {
                return null;
            }
        }

        if($reverse) {
            $result = $amount / $currency->value * $currency->par;
        } else {
            $result = $amount * $currency->value / $currency->par;
        }

        return $result;
    }

    public function currencyByDay(Carbon $date): Collection
    {
        $currencies = new Currency();
        return $currencies->currencyByDay($date);
    }


    public function getCurrenciesList(): Collection
    {
        if(Cache::has('centralBankCurrencies')) {
            $currencies = Cache::get('centralBankCurrencies');
        } else {
            $currencies = CentralBankCurrencyModel::all();
            if(config('centralbankcurrency.cache.enable')) {
                Cache::put('centralBankCurrencies', $currencies, config('centralbankcurrency.cache.time'));
            }
        }

        return $currencies;
    }

    public function clearCache()
    {
        Cache::forget('centralBankCurrencies');
    }
}