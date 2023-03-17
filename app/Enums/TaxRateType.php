<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static INCLUDED()
 * @method static static EXCLUDED()
 */
final class TaxRateType extends Enum
{
    const INCLUDED = 1;
    const EXCLUDED = 2;
}
