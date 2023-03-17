<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id')->unsigned()->nullable(false);
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->bigInteger('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('sell_price',12,2)->default(0)->nullable(false);
            $table->integer('sell_tax_rate_type_id')->default(2)->nullable(false);
            $table->integer('sell_taxable_method_type_id')->default(1)->nullable(false);
            $table->decimal('stocking_price',12,2)->default(0)->nullable(false);
            $table->integer('stocking_tax_rate_type_id')->default(2)->nullable(false);
            $table->integer('stocking_taxable_method_type_id')->default(1)->nullable(false);
            $table->date('in_stock_on')->nullable();
            $table->decimal('avg_stocking_price',12,2)->default(0)->nullable(false);
            $table->decimal('this_stock_quantity',12,2)->default(0)->nullable(false);
            $table->date('last_sell_on')->nullable();
            $table->date('last_purchase_on')->nullable();
            $table->date('last_entry_on')->nullable();
            $table->date('last_exit_on')->nullable();
            $table->decimal('total_sell_quantity',12,2)->default(0)->nullable();
            $table->decimal('total_purchase_quantity',12,2)->default(0)->nullable();
            $table->decimal('total_entry_quantity',12,2)->default(0)->nullable();
            $table->decimal('total_exit_quantity',12,2)->default(0)->nullable();
            $table->decimal('stocktaking_quantity',12,2)->default(0)->nullable(false);
            $table->integer('is_stocktaking')->default(0)->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
