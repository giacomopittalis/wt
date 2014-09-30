<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthConsultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('health_consult', function($table)
		{
			$table->increments('id');

			//foreign key on clients
			$table->integer('client_id')->unsigned();	
			$table->foreign('client_id')->references('id')->on('clients');

			//foreign key on locations
			$table->integer('location_id')->unsigned();	
			$table->foreign('location_id')->references('id')->on('locations');

			//foreign key on employees
			$table->integer('employee_id')->unsigned();	
			$table->foreign('employee_id')->references('id')->on('employees');

			$table->integer('under_medical_care')
				  ->nullable();

			$table->text('info')->nullable();
			$table->text('topics')->nullable();
			$table->text('soap')->nullable();

			$table->integer('follow_up')->nullable();
			$table->text('notes')->nullable();

			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
		Schema::drop('health_consult');
	}

}
