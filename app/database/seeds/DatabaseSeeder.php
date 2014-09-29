<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('ClientsTableSeeder');
		$this->command->info('Clients Table Seeded');

		$this->call('LocationsTableSeeder');
		$this->command->info('Locations Table Seeded');
	}

}

class ClientsTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('clients')->delete();

		$clients = array
				   (
				   	 'Microsoft Indonesia',
				   	 'Google Indonesia'
				   );
		foreach($clients as $c)
		{
			Client::create(array('name' => $c));
		}
	}
}

class LocationsTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('locations')->delete();

		$loc = array
			   (
			   	 'DKI Jakarta',
			   	 'Jawa Barat'
			   );
		foreach($loc as $c)
		{
			Location::create(array('name' => $c));
		}
	}
}