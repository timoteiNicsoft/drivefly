<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printer_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('barcode1');
            $table->string('name');
            $table->string('mobile');
            $table->string('refNum');
            $table->string('carReg');
            $table->string('carModel');
            $table->string('carColour');
            $table->string('outDate');
            $table->string('backDate');
            $table->string('outTime');
            $table->string('backTime');
            $table->string('terminal_out');
            $table->string('terminal_in');
            $table->string('returnFlightNum');
            $table->string('ppl');
            $table->string('bigType');
            $table->string('backDateShort');
            $table->string('backTime2');
            $table->string('terminal_in2');
            $table->string('refNum2');
            $table->string('carReg2');
            $table->string('carModel2');
            $table->string('carColour2');
            $table->string('barcode3');
            $table->string('xtratext');
            $table->string('extraName');
            $table->string('refNum3');
            $table->string('carReg3');
            $table->string('carModel3');
            $table->string('carColour3');
            $table->string('backDate3');
            $table->string('backTime3');
            $table->string('terminal_in3');
            $table->string('returnFlightNum3');
            $table->string('type');
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
        Schema::dropIfExists('printer_settings');
    }
}
