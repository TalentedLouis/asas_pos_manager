<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("staffs", function (Blueprint $table) {
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
        Schema::dropIfExists("staffs");
    }
}
