<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            //this id indicates number within one client
            //so every account will have 1,2,3... appointment's ids.
            $table->integer('per_client_id')->default(0);

            $table->integer('client_id')->index();

            $table->dateTime('datetime')->index();
            $table->integer('duration_minutes')->default(0);

            $table->float('income')->default(0.0);

            $table->text('notes')->default('');

            $table->enum('status',[0,1,2])->default(0); //0-normal, 1-cancelled, 2-missed by client

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointments');
    }
}
