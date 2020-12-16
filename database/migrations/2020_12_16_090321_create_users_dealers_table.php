<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dealer_login');
            $table->string('dealer_password');
            $table->string('dealer_brandname');
            $table->string('dealer_urname');
            $table->string('dealer_city');
            $table->string('dealer_street');
            $table->string('dealer_house');
            $table->string('dealer_houseblock');
            $table->string('dealer_office');
            $table->string('dealer_phone');
            $table->string('dealer_email');
            $table->string('dealer_website');
            
            $table->integer('added_by');
            $table->timestamps();
            $table->integer('changed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_dealers');
    }
}
