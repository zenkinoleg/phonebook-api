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
            $table->string('first_name',32);
            $table->string('last_name',32)->nullable();
            $table->string('phone_number',17)->unique();
            $table->string('country',2);
            $table->string('timezone',64);
            $table->timestamps();

			$table->index(['country']);
			$table->index(['last_name','first_name']);
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
