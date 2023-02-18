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
        Schema::table('lotus_reservations', function (Blueprint $table) {
            $table->dropColumn('checked_in_at');
        });

        Schema::table('lotus_reservations', function (Blueprint $table) {
            $table->json('ticket_check_ins')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotus_reservations', function (Blueprint $table) {
            $table->dropColumn('ticket_check_ins');
        });

        Schema::table('lotus_reservations', function (Blueprint $table) {
            $table->timestamp('checked_in_at')->nullable();
        });
    }
};
