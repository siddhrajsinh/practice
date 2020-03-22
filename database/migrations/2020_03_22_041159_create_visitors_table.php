<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',50)->comment('visitor first name')->nullable();
            $table->string('last_name',50)->comment('visitor last name')->nullable();
            $table->string('email',50)->comment('visitor user email')->nullable();
            $table->date('date_of_birth')->comment('visitor date of birth')->nullable();
            $table->string('ip_address',30)->comment('visitor ip address')->nullable();
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
        Schema::dropIfExists('visitors');
    }
}
