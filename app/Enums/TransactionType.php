<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SALES()
 * @method static static PURCHASE()
 * @method static static ENTRY_STOCK()
 * @method static static EXIT_STOCK()
 * @method static static DEPOSITS()
 * @method static static WITHDRAWALS()
 */
final class TransactionType extends Enum
{
    const SALES = 1;
    const PURCHASE = 2;
    const ENTRY_STOCK = 3;
    const EXIT_STOCK = 4;
    const DEPOSITS = 5;
    const WITHDRAWALS = 6;
}
