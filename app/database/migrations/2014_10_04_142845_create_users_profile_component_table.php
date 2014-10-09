<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProfileComponentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users_profile_components', function($table)
		{
			$table->increments('id');

			//foreign key on users
			$table->integer('user_id')->unsigned();	
			$table->foreign('user_id')->references('id')->on('users');

			$table->string('name')
				  ->nullable();

			$table->text('value')
				  ->nullable();

			$table->dateTime('created_at')
				  ->nullable();
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
		Schema::drop('user_profile_components');
	}

}
