<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('employees', function($table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('middle_name')
				  ->nullable();
			$table->string('last_name');
			$table->string('sex');
			$table->date('dob');
			$table->string('department');
			$table->string('position');
			$table->string('hire_year');
			$table->string('hire_type');
			$table->string('health_plan');
			$table->text('image');

			//foreign key on clients
			$table->integer('client_id')->unsigned();	
			$table->foreign('client_id')->references('id')->on('clients');

			//foreign key on locations
			$table->integer('location_id')->unsigned();	
			$table->foreign('location_id')->references('id')->on('locations');

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
		Schema::drop('employees');
	}

}
