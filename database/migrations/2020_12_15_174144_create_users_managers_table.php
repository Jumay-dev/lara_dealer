<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id');
            $table->string('manager_name');
            $table->string('manager_surname');
            $table->string('manager_patronymic');
            $table->string('manager_phone');
            $table->string('manager_email');

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
        Schema::dropIfExists('users_managers');
    }
}
