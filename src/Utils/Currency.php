<?php


namespace Grechanyuk\CentralBankCurrency\Utils;


use Grechanyuk\CentralBankCurrency\Models\CentralBankCurrency;
use Illuminate\Support\Carbon;
use \Grechanyuk\CentralBankCurrency\Facades\CentralBankCurrency as CentralBankCurrencyFacade;

class Currency extends Api
{
    public function updateCurrency()
    {
        $currencies = $this->get('XML_daily.asp');
        $currenciesArr = [];
        foreach ($currencies as $currency) {
            $currenciesArr[] = CentralBankCurrency::updateOrCreate([
                'cb_code' => (string)$currency['ID']
            ], [
                'name' => (string)$currency->Name,
                'par' => (int)$currency->Nominal,
                'iso_code' => (string)$currency->CharCode,
                'value' => (float)str_replace(',', '.', (string)$currency->Value)
            ]);
        }

        CentralBankCurrencyFacade::clearCache();

        return collect($currenciesArr);
    }

    public function currencyByDay(Carbon $date)
    {
        $currencies = $this->get('XML_daily.asp', ['date_req' => $date->format('d/m/Y')]);

        $currenciesArr = [];

        foreach ($currencies as $currency) {
            $currenciesArr[] = new CentralBankCurrency([
                'cb_code' => (string)$currency['ID'],
                'name' => (string)$currency->Name,
                'par' => (int)$currency->Nominal,
                'iso_code' => (string)$currency->CharCode,
                'value' => (float)str_replace(',', '.', (string)$currency->Value)
            ]);
        }

        return collect($currenciesArr);
    }
}