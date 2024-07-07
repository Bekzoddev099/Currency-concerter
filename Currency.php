<?php

declare(strict_types=1);

class Currency
{
    const CB_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";

    public function exchange(float|int $amount, string $from, string $to): float|int
    {
        $currencies = $this->customCurrencies();
        if (!isset($currencies[$from]) || !isset($currencies[$to])) {
            throw new Exception("Invalid currency code.");
        }

        $fromRate = $currencies[$from];
        $toRate = $currencies[$to];
        
    
        $amountInUzs = $amount * $fromRate;
        return $amountInUzs / $toRate;
    }

    public function getCurrencyInfo()
    {
        $currencyInfo = file_get_contents(self::CB_URL);
        return json_decode($currencyInfo);
    }

    public function customCurrencies(): array
    {
        $currencies = (array) $this->getCurrencyInfo();
        $orderedCurrencies = [];
        foreach ($currencies as $currency) {
            $orderedCurrencies[$currency->Ccy] = $currency->Rate;
        }

        return $orderedCurrencies;
    }
}
?>
