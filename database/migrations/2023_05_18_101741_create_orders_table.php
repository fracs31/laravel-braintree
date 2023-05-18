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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); //id
            $table->dateTime("date"); //data
            $table->boolean("status")->default(0); //stato
            $table->string("first_name", 100); //nome del cliente
            $table->string("last_name", 100); //cognome del cliente
            $table->string("email"); //email del cliente
            $table->string("phone", 20); //telefono del cliente
            $table->string("address", 255); //indirizzo del cliente
            $table->string("cap", 5); //cap del cliente
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
