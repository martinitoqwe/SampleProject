<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consultation_id')->unsigned();
            $table->string('drug_name');
            $table->integer('times');
            $table->integer('days');
            $table->timestamps();
        });
       Schema::table('prescriptions', function($table) {
            $table->foreign('consultation_id')->references('id')->on('consultations')->onCascade('delete');
        });  

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
