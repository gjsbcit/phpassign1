<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNotesTableV3 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::drop('notes');

		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user')->unique();
			$table->string('note')->nullable();
			$table->string('tbd')->nullable();
			$table->string('link')->nullable();
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
		//
	}

}
