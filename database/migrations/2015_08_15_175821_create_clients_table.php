<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');

            //this id indicates number within one account
            //so every account will have 1,2,3... client's ids.
            $table->integer('per_account_id')->default(0);

            $table->integer('account_id')->index();

            $table->string('image')->default(''); //url to image

            $table->string('first_name')->index()->default('');
            $table->string('last_name')->index()->default('');
            $table->date('birthdate');

            $table->text('notes')->default('');

            $table->string('email')->default('')->unique();
            $table->string('phone')->default('')->unique();

            $table->string('facebook_url')->default('');
            $table->string('twitter_url')->default('');
            $table->string('vk_url')->default('');

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
        Schema::drop('clients');
    }
}
