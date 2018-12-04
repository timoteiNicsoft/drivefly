<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consolidatorID');
            $table->bigInteger('customerID');
            $table->string('product');
            $table->string('payment');
            $table->integer('airportID');
            $table->integer('carparkID');
            $table->integer('typeID');
            $table->string('refNum');
            $table->string('hotel');
            $table->dateTime('leavingDate');
            $table->dateTime('returnDate');
            $table->string('returnFlightNum');
            $table->dateTime('returnFlightTime');
            $table->text('terminal_out');
            $table->text('terminal_in');
            $table->string('carModel');
            $table->string('carColour');
            $table->string('carReg');
            $table->string('status');
            $table->decimal('amountPaid',7,2);
            $table->decimal('net',6,2);
            $table->string('notes');
            $table->integer('ppl');
            $table->string('dfArea');
            $table->integer('discountID');
            $table->integer('adminID');
            $table->string('vendortxcode');
            $table->string('payPending');
            $table->string('s4');
            $table->string('s5');
            $table->string('s5name');
            $table->string('s5reg');
            $table->string('s1');
            $table->string('s2');
            $table->string('s2name');
            $table->string('s2reg');
            $table->string('s3');
            $table->string('firstname');
            $table->binary('surname');
            $table->string('email');
            $table->string('password');
            $table->string('mobile');
            $table->string('address');
            $table->string('postcode');
            $table->string('city');
            $table->string('emailOptOut');
            $table->string('consolidatorName');
            $table->string('fullName');
            $table->decimal('commission', 7, 2);
            $table->integer('vat');
            $table->smallInteger('status_temp');
            $table->string('address1');
            $table->string('address2');
            $table->string('postcode_v2');
            $table->string('town');
            $table->string('mobile_v2');
            $table->string('email_v2');
            $table->smallInteger('hidden');
            $table->integer('google_booking_id');
            $table->text('expeditor');
            $table->string('picked_by_val');
            $table->dateTime('picked_by_time');
            $table->string('dropped_by');
            $table->integer('dropped_by_time');
            $table->dateTime('created');
            $table->dateTime('lastUpdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
