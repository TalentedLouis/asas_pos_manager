<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static STANDARD_TAX()
 * @method static static REDUCED_TAX()
 * @method static static NONE_TAX()
 */
final class TaxableMethodType extends Enum
{
    const STANDARD_TAX = 1;
    const REDUCED_TAX = 2;
    const NONE_TAX = 3;
}
