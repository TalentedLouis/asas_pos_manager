<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_slip_id')->unsigned()->nullable(false);
            $table->foreign('transaction_slip_id')->references('id')->on('transaction_slips');
            $table->integer('line_number')->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('quantity', 12,2)->nullable();
            $table->decimal('unit_price', 12,2)->nullable();
            $table->integer('tax_rate_type_id')->nullable();
            $table->integer('taxable_method_type_id')->nullable();
            $table->decimal('final_unit_price_tax_included', 12,2)->nullable();
            $table->decimal('final_unit_price_tax_excluded', 12,2)->nullable();
            $table->decimal('subtotal_tax_included', 12,2)->nullable();
            $table->decimal('subtotal_tax_excluded', 12,2)->nullable();
            $table->decimal('ctax_price', 12,2)->nullable();
            $table->decimal('ctax_rate', 12,2)->nullable();
            $table->decimal('discount_price', 12,2)->nullable();
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
        Schema::dropIfExists('transaction_lines');
    }
}
