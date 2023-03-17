<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_slips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id')->unsigned()->nullable(false);
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->integer('terminal_number')->nullable();
            $table->string('slip_no', 255);
            $table->bigInteger('staff_id')->unsigned()->nullable(false);
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->date('transacted_on')->nullable();
            $table->integer('transaction_type_id')->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable(true);
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->bigInteger('supplier_target_id')->unsigned()->nullable(true);
            $table->foreign('supplier_target_id')->references('id')->on('supplier_targets');
            $table->bigInteger('entry_exit_target_id')->unsigned()->nullable(true);
            $table->foreign('entry_exit_target_id')->references('id')->on('entry_exit_targets');
            $table->decimal('total_quantity', 12,2)->nullable();
            $table->decimal('total_cost', 12,2)->nullable();
            $table->decimal('total_amount_ctax_included', 12,2)->nullable();
            $table->decimal('total_amount_ctax_excluded', 12,2)->nullable();
            $table->decimal('total_amount_ctax', 12,2)->nullable();
            $table->decimal('total_amount_ctax1_included', 12,2)->nullable();
            $table->decimal('total_amount_ctax1', 12,2)->nullable();
            $table->decimal('total_amount_ctax2_included', 12,2)->nullable();
            $table->decimal('total_amount_ctax2', 12,2)->nullable();
            $table->decimal('total_amount_ctax3_included', 12,2)->nullable();
            $table->decimal('total_discount_price', 12,2)->nullable();
            $table->decimal('total_payment_amount', 12,2)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->decimal('cash_deposit_amount', 12,2)->nullable();
            $table->decimal('cash_payout_amount', 12,2)->nullable();
            $table->integer('qr_sequence_id')->nullable();
            $table->string('qr_service_name', 255)->nullable();
            $table->string('qr_slip_number', 255)->nullable();
            $table->string('qr_trunsaction_number', 255)->nullable();
            $table->integer('credit_sequence_id')->nullable();
            $table->string('credit_service_name', 255)->nullable();
            $table->string('credit_approval_number', 255)->nullable();
            $table->string('credit_company_id', 255)->nullable();
            $table->integer('credit_condition_id')->nullable();
            $table->string('credit_slip_number', 255)->nullable();
            $table->string('credit_trunsaction_number', 255)->nullable();
            $table->integer('ic_sequence_id')->nullable();
            $table->string('ic_service_name', 255)->nullable();
            $table->integer('ic_balance')->nullable();
            $table->integer('ic_condition_id')->nullable();
            $table->string('ic_sprw_id', 255)->nullable();
            $table->bigInteger('ic_trunsaction_number')->nullable();
            $table->integer('ic_approval_number')->nullable();
            $table->integer('ic_slip_number')->nullable();
            $table->integer('ic_before_balance')->nullable();
            $table->boolean('is_refund')->nullable();
            $table->string('refund_name', 255)->nullable();
            $table->boolean('is_training')->nullable();
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
        Schema::dropIfExists('transaction_slips');
    }
}
