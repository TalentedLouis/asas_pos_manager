<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionLine20211228 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->decimal('this_stock_quantity',10,0)->change();
            $table->decimal('exclude_tax',10,0)->change();
            $table->decimal('include_tax',10,0)->change();
            $table->decimal('quantity',10,0)->change();
            $table->decimal('unit_price',10,0)->change();
            $table->decimal('final_unit_price_tax_included',10,0)->change();
            $table->decimal('final_unit_price_tax_excluded',10,0)->change();
            $table->decimal('subtotal_tax_included',10,0)->change();
            $table->decimal('subtotal_tax_excluded',10,0)->change();
            $table->decimal('ctax_price',10,0)->change();
            $table->decimal('discount_price',10,0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->decimal('this_stock_quantity',12,2)->change();
            $table->decimal('exclude_tax',12,2)->change();
            $table->decimal('include_tax',12,2)->change();
            $table->decimal('quantity',12,2)->change();
            $table->decimal('unit_price',12,2)->change();
            $table->decimal('final_unit_price_tax_included',12,2)->change();
            $table->decimal('final_unit_price_tax_excluded',12,2)->change();
            $table->decimal('subtotal_tax_included',12,2)->change();
            $table->decimal('subtotal_tax_excluded',12,2)->change();
            $table->decimal('ctax_price',12,2)->change();
            $table->decimal('discount_price',12,2)->change();
        });
    }
}
