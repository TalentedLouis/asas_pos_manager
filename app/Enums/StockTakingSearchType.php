<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ALL()
 * @method static static DIFF_ALL()
 * @method static static DIFF_DONE()
 * @method static static DIFF_NOTDONE()
 */
final class StockTakingSearchType extends Enum
{
    const ALL = 1;
    const DIFF_ALL = 2;
    const DIFF_DONE = 3;
    const DIFF_NOTDONE = 4;
}
