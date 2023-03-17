<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CASH()
 * @method static static CREDIT()
 * @method static static E_MONEY()
 * @method static static QR_PAY()
 */
final class PaymentMethodType extends Enum
{
    const CASH =   1;
    const CREDIT =   2;
    const E_MONEY = 3;
    const QR_PAY = 4;
}
