<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotus_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('holder_type');
            $table->string('name');
            $table->string('email');
            $table->integer('tickets');
            $table->string('dietary')->nullable();
            $table->string('accommodations')->nullable();
            $table->string('affiliation')->nullable();
            $table->integer('charged_price')->default(0);
            $table->boolean('pending')->default(false);
            $table->string('stripe_payment_id')->nullable();
            $table->integer('donation')->nullable();
            $table->string('donation_stripe_payment_id')->nullable();
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
        Schema::dropIfExists('lotus_reservations');
    }
};
