<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('status', ['initial', 'pending', 'success', 'failed', 'declined', 'dispute'])->nullable();
            $table->string('currency')->nullable();
            $table->string('token_id')->nullable();
            $table->string('card_last4')->nullable();
            $table->string('card_id')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('charge_id_or_token')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('description')->nullable();
            $table->string('local_transaction_id')->nullable();
            //payment created column will be use by gateway
            $table->integer('payment_created')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
