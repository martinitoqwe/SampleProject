<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacylists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pharmacy_id')->unsigned();
            $table->string('pharmacy_name');
            $table->timestamps();
        });
        Schema::table('pharmacylists', function($table) {
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacylists');
    }
}
