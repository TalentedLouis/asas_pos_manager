<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Code()
 * @method static static Name()
 */
final class ProductSearchType extends Enum implements LocalizedEnum
{
    const Code =   1;
    const Name =   2;
}
