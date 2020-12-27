<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->string('phone');
            $table->string('email');
            $table->integer('company_id');
            
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
        Schema::dropIfExists('meta_users');
    }
}
