<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MAN()
 * @method static static WOMAN()
 */
final class SexType extends Enum
{
    const MAN = 1;
    const WOMAN = 2;
}
