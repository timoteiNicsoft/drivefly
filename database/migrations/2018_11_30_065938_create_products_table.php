<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('airport_id');
            $table->integer('service_id');
            $table->text('product_info');
            $table->text('product_description');
            $table->text('product_directions');
            $table->tinyInteger('is_amendable');
            $table->tinyInteger('is_refundable');
            $table->integer('show_hide_glag');
            $table->text('prices_array');
            $table->text('prices_grid_A');
            $table->text('prices_grid_B');
            $table->text('prices_grid_C');
            $table->text('prices_grid_D');
            $table->text('prices_grid_E');
            $table->text('prices_grid_F');
            $table->text('promo_array');
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
        Schema::dropIfExists('products');
    }
}
