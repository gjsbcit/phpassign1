<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::drop('users');

		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('emailaddress')->unique();
			$table->string('password', 80);
			$table->boolean('confirmed')->default(0);
			$table->string('confirmation_code')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

}
