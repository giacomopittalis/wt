<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('feeds', function($table)
		{
			$table->increments('id');

			//foreign key on users
			$table->integer('user_id')->unsigned();	
			$table->foreign('user_id')->references('id')->on('users');

			$table->string('ftype')
				  ->nullable();

			$table->text('fcomment')
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
		Schema::drop('feeds');
	}

}
