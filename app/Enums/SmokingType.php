<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NO_SMOKING()
 * @method static static SMOKING()
 */
final class SmokingType extends Enum
{
    const NO_SMOKING = 1;
    const SMOKING = 2;
}
