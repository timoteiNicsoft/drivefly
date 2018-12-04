<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackDenominatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_denominators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_id');
            $table->integer('airport_id');
            $table->integer('service_id');
            $table->string('day_incremental');
            $table->string('price_incremental');
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
        Schema::dropIfExists('pack_denominators');
    }
}
