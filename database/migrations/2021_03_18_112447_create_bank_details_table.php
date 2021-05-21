<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bank_details',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('external_id')->default(0);
                $table->string('company_id');
                $table->string('name');
                $table->string('shortname');
                $table->string('legal_form');
                $table->string('director');
                $table->string('address');
                $table->string('post_address');
                $table->string('phone');
                $table->string('email');
                $table->string('inn');
                $table->string('ogrn');
                $table->string('bank_details')->default('');
                $table->string('licenses')->default('');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_details');
    }
}
