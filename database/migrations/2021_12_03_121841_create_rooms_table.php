<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("rooms", function (Blueprint $table) {
            $table->id();
            $table->string("name", 255)->nullable(false);
            $table
                ->bigInteger("shop_id")
                ->unsigned()
                ->nullable(false);
            $table
                ->foreign("shop_id")
                ->references("id")
                ->on("shops");
            $table
                ->bigInteger("type_id")
                ->unsigned()
                ->nullable(false);
            $table
                ->foreign("type_id")
                ->references("id")
                ->on("types");
            $table->integer("smoking_type_id")->nullable(false);
            $table->integer("pc_type_id")->nullable(false);
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
        Schema::dropIfExists("rooms");
    }
}
