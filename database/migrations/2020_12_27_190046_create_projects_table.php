<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('brand');
            $table->string('ur_name');
            $table->string('inn');
            $table->string('comment');
            $table->string('datetime_start');
            $table->string('datetime_end');

            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('block');
            $table->string('office');

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
        Schema::dropIfExists('projects');
    }
}
