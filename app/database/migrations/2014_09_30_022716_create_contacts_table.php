<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('contacts', function($table)
		{
			$table->increments('id');

			$table->string('mode');
			$table->string('method');
			$table->date('start');

			//foreign key on clients
			$table->integer('client_id')->unsigned();	
			$table->foreign('client_id')->references('id')->on('clients');

			//foreign key on locations
			$table->integer('location_id')->unsigned();	
			$table->foreign('location_id')->references('id')->on('locations');

			//foreign key on employees
			$table->integer('employee_id')->unsigned();	
			$table->foreign('employee_id')->references('id')->on('employees');

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
		Schema::drop('contacts');
	}

}
