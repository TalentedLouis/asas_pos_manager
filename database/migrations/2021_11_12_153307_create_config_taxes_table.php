<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_taxes', function (Blueprint $table) {
            $table->id();
            $table->decimal('tax_rate1', 5, 2)->nullable(false);
            $table->decimal('tax_rate2', 5, 2)->nullable(false);
            $table->date('started_on')->nullable((false));
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
        Schema::dropIfExists('config_taxes');
    }
}
