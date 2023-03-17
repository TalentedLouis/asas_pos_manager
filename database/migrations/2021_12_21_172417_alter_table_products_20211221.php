<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProducts20211221 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->string('product_code', 20)->after('product_id');
            $table->string('product_name', 255)->after('product_code');
            $table->decimal('avg_stocking_price', 12, 2)->nullable()->default(0)->after('product_name');
            $table->decimal('this_stock_quantity', 12, 2)->nullable()->default(0)->after('avg_stocking_price');
            $table->decimal('exclude_tax', 12, 2)->nullable()->default(0)->after('this_stock_quantity');
            $table->decimal('include_tax', 12, 2)->nullable()->default(0)->after('exclude_tax');
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
            $table->dropColumn('product_code');
            $table->dropColumn('product_name');
            $table->dropColumn('avg_stocking_price');
            $table->dropColumn('this_stock_quantity');
            $table->dropColumn('exclude_tax');
            $table->dropColumn('include_tax');
        });
    }
}
