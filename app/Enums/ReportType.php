<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReportType extends Enum
{
    const DAILY_MONTH_RESULT = 1;   //日報・月報
    const GROUP_SALE_PURCHASE = 2;  //グループ別売上仕入金額表
    const PRODUCT_SALE = 2;         //商品別売上金額表
    const TIME_SALE = 3;            //時間帯別売上金額表
    const SALE_MEI = 4;             //売上明細リスト
    const PURCHASE_MEI = 5;         //仕入明細リスト
    const ENTRY_EXIT_MEI = 6;       //入出庫明細リスト
    const PRODUCT_STOCK_MONEY = 7;  //商品別在庫金額表
}
