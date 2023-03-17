<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable(false);
            $table->integer('customer_class_id')->nullable(false)->default(1);
            $table->string('name',255)->nullable();
            $table->string('read',255)->nullable();
            $table->string('sex',20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('zip_code',20)->nullable();
            $table->string('address_1',255)->nullable();
            $table->string('address_2',255)->nullable();
            $table->string('address_3',255)->nullable();
            $table->string('tel',20)->nullable();
            $table->string('portable',20)->nullable();
            $table->string('note',255)->nullable();
            $table->date('entranced_on')->nullable();
            $table->date('last_visited_on')->nullable();
            $table->date('point_lost_on')->nullable();
            $table->decimal('this_point',12,2)->nullable(false)->default(0);
            $table->decimal('this_money',12,2)->nullable(false)->default(0);
            $table->decimal('total_point',12,2)->nullable(false)->default(0);
            $table->decimal('total_money',12,2)->nullable(false)->default(0);
            $table->decimal('total_count',12,2)->nullable(false)->default(0);
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
        Schema::dropIfExists('customers');
    }
}
