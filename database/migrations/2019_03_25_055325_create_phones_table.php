<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonebookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonebook', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',34);
            $table->string('last_name',34)->nullable();
            $table->string('phone_number')->unique();
            $table->string('country',2);
            $table->string('timezone',256)->nullable();
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
        Schema::dropIfExists('phones');
    }
}
