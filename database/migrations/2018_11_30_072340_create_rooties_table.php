<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prs_username');
            $table->text('prs_password');
            $table->text('prs_member_guid');
            $table->text('apk_token');
            $table->tinyInteger('authority_level');
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
        Schema::dropIfExists('rooties');
    }
}
