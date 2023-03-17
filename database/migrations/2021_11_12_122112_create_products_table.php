<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable(false);
            $table->string('name',255)->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable(false);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->bigInteger('genre_id')->unsigned()->nullable(false);
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->bigInteger('maker_id')->unsigned()->nullable(false);
            $table->foreign('maker_id')->references('id')->on('makers');
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
        Schema::dropIfExists('products');
    }
}
