<?php

namespace App\Services;

use App\Enums\TaxableMethodType;
use App\Enums\TaxRateType;
use App\Repositories\ConfigTaxRepositoryInterface;

class TaxService
{
    private $repository;
    public function __construct(ConfigTaxRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }
    public function getNowRate(){
        return $this->repository->getNow();
    }
    public function calcTax($price, $taxRateType, $taxableMethodType){
        $configTax = $this->getNowRate();
        $taxRate = 0;
        if ($taxableMethodType == TaxableMethodType::NONE_TAX) {
            return [
                'priceTaxIncluded' => $price,
                'priceTaxExcluded' => $price,
                'taxPrice' => 0,
                'taxRate' => $taxRate,
            ];
        } elseif ($taxableMethodType == TaxableMethodType::STANDARD_TAX) {
            $taxRate = $configTax->tax_rate1;
        } elseif ($taxableMethodType == TaxableMethodType::REDUCED_TAX) {
            $taxRate = $configTax->tax_rate2;
        }
        if ($taxRateType == TaxRateType::INCLUDED) {
            $taxPrice = floor($price * $taxRate / (100 + $taxRate));
            return [
                'priceTaxIncluded' => $price,
                'priceTaxExcluded' => $price - $taxPrice,
                'taxPrice' => $taxPrice,
                'includeTax' => $taxPrice,
                'excludeTax' => 0,
                'taxRate' => $taxRate,
            ];
        } else {
            $taxPrice = floor($price * ($taxRate / 100));
            return [
                'priceTaxIncluded' => $price + $taxPrice,
                'priceTaxExcluded' => $price,
                'taxPrice' => $taxPrice,
                'includeTax' => 0,
                'excludeTax' => $taxPrice,
                'taxRate' => $taxRate,
            ];
        }
    }
}
