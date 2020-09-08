<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribedlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribedlists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pharmacy_id')->unsigned();
            $table->integer('consultation_id')->unsigned();
            $table->integer('prescription_id')->unsigned();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::table('prescribedlists', function($table) {
            $table->foreign('pharmacy_id')->references('id')->on('pharmacylists')->onCascade('delete');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onCascade('delete');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescribedlists');
    }
}
