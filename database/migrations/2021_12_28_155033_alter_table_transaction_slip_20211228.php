<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionSlip20211228 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_slips', function (Blueprint $table) {
            $table->decimal('total_quantity',10,0)->change();
            $table->decimal('total_cost',10,0)->change();
            $table->decimal('total_amount_ctax_included',10,0)->change();
            $table->decimal('total_amount_ctax_excluded',10,0)->change();
            $table->decimal('total_amount_ctax',10,0)->change();
            $table->decimal('total_amount_ctax1_included',10,0)->change();
            $table->decimal('total_amount_ctax1',10,0)->change();
            $table->decimal('total_amount_ctax2_included',10,0)->change();
            $table->decimal('total_amount_ctax2',10,0)->change();
            $table->decimal('total_amount_ctax3_included',10,0)->change();
            $table->decimal('total_discount_price',10,0)->change();
            $table->decimal('total_payment_amount',10,0)->change();
            $table->decimal('cash_deposit_amount',10,0)->change();
            $table->decimal('cash_payout_amount',10,0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_slips', function (Blueprint $table) {
            $table->decimal('total_quantity',12,2)->change();
            $table->decimal('total_cost',12,2)->change();
            $table->decimal('total_amount_ctax_included',12,2)->change();
            $table->decimal('total_amount_ctax_excluded',12,2)->change();
            $table->decimal('total_amount_ctax',12,2)->change();
            $table->decimal('total_amount_ctax1_included',12,2)->change();
            $table->decimal('total_amount_ctax1',12,2)->change();
            $table->decimal('total_amount_ctax2_included',12,2)->change();
            $table->decimal('total_amount_ctax2',12,2)->change();
            $table->decimal('total_amount_ctax3_included',12,2)->change();
            $table->decimal('total_discount_price',12,2)->change();
            $table->decimal('total_payment_amount',12,2)->change();
            $table->decimal('cash_deposit_amount',12,2)->change();
            $table->decimal('cash_payout_amount',12,2)->change();
        });
    }
}
