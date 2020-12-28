<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('external_id');

            $table->string('brand');
            $table->string('ur_name');
            $table->string('inn');

            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('block');
            $table->string('office');
            $table->string('comment');

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('clinics');
    }
}
