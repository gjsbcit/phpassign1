<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('emailaddress')->unique();
			$table->string('password', 80);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}


}
