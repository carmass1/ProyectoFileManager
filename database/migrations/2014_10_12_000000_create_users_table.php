<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
            $table->string('name');
            $table->string('password');
			$table->string('email')->unique();
			$table->string('ruc')->nullable();
			$table->string('flag')->nullable();
			$table->string('group')->nullable();
			$table->mediumtext('direction')->nullable();
			$table->mediumtext('contacts')->nullable();
			$table->boolean('estado')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
