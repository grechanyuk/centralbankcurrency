<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentralBankCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_bank_currencies', function (Blueprint $table) {
            if(\Illuminate\Support\Facades\App::version() < 5.8) {
                $table->increments('id');
            } else {
                $table->bigIncrements('id');
            }

            $table->string('name');
            $table->integer('par');
            $table->string('cb_code')->index();
            $table->string('iso_code')->index();
            $table->string('icon')->nullable();
            $table->float('value', 8, 4);
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
        Schema::dropIfExists('central_bank_currencies');
    }
}
