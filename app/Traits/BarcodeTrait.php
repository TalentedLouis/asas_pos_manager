<?php

namespace App\Traits;

trait BarcodeTrait
{
    /**
     * @param $sequence
     * @param $prefix
     * @return string
     */
    private function newBarcodeJan13($sequence, $prefix=null): string
    {
        $sequenceLength = 12 - strlen((string)$prefix);
        $jan_code = (string)$prefix . str_pad($sequence, $sequenceLength, '0', STR_PAD_LEFT);
        $jan_code .= (string)$this->calcCheckDigitJan13($jan_code);
        return (string)$jan_code;
    }

    /**
     * @param string $janCode
     * @return int
     */
    private function calcCheckDigitJan13(string $janCode): int{
        // 数値チェック
        if (!is_numeric($janCode)) {
            return false;
        }
        // 桁数チェック
        
        // 20230101 UPD S
        /*
        if (!(strlen($janCode) == 12 or strlen($janCode) == 13)) {
            return false;
        }
        */
        if (strlen($janCode) == 13) {
            $janCode = substr($janCode, 0, 12);
        }
        // 20230101 UPD E
        
        $janArr = str_split(substr($janCode, 0, 12));
        $even = 0;
        $odd = 0;
        foreach ($janArr as $index => $value) {
            if ($index % 2 == 0) {
                // 偶数
                $even += $value;
            } else {
                // 奇数
                $odd += $value;
            }
        }
        $checkDigit = 10 - intval(substr($odd * 3 + $even,-1,1));
        if ($checkDigit == 10) {
            return 0;
        } else {
            return $checkDigit;
        }
    }
}
