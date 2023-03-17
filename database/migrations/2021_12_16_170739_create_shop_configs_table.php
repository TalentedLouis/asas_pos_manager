<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_configs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id')->unsigned()->nullable(false);
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->integer('is_inventory')->default(0)->nullable(false);
            $table->integer('delay_minutes')->default(30)->nullable(false);
            $table->integer('exit_reserve_minutes')->default(5)->nullable(false);
            $table->integer('slip_number_sequence')->default(1)->nullable(false);
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
        Schema::dropIfExists('shop_configs');
    }
}
