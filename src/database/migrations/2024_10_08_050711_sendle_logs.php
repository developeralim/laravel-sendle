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
        Schema::create('sendle_logs', function (Blueprint $table) {
            $table->id();
            $table->string('eventname');
            $table->foreignId('orderid')->references('id')->on('orders')->cascadeOnDelete()->restrictOnUpdate();
            $table->text('logs')->nullable();
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
        Schema::dropIfExists('sendle_logs');
    }
};
