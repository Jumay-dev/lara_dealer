<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('name');
            $table->string('ur_name');
            $table->string('inn');
            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('house_block');
            $table->string('office');
            $table->string('phone');
            $table->string('email');
            $table->string('website');

            $table->string('created_by');
            $table->timestamps();
            $table->string('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_companies');
    }
}
