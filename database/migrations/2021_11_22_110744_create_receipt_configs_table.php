<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_configs', function (Blueprint $table) {
            $table->id();
            $table
                ->bigInteger('shop_id')
                ->unsigned()
                ->nullable(false);
            $table
                ->foreign('shop_id')
                ->references('id')
                ->on('shops');
            $table->string('name', 255)->nullable(false);
            $table->string('address', 255)->nullable(false);
            $table->string('telephone', 255)->nullable(false);
            $table->string('text_1', 255)->nullable();
            $table->string('text_2', 255)->nullable();
            $table->string('text_3', 255)->nullable();
            $table->string('text_4', 255)->nullable();
            $table->string('text_5', 255)->nullable();
            $table->string('header_image', 255)->nullable();
            $table->string('footer_image', 255)->nullable();
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
        Schema::dropIfExists('receipt_configs');
    }
}
