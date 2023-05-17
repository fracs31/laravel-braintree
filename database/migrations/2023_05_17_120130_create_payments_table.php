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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); //id
            $table->double('amount', 7, 2); //quantità
            $table->dateTime('date'); //data
            $table->string('card_type', 50); //tipologia della carta
            $table->string('cardholder_name', 200); //proprietario della carta
            $table->string('card_number', 16); //numero della carta
            $table->date('card_expiration'); //scadenza della carta
            $table->string('card_cvv', 3); //cvv della carta
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
