<?php

namespace Database\Seeders;

use App\Models\Car\Car;
use App\Models\User;
use App\Models\User\UserPhone;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		User::factory()->count(10000)->create()->each(function ($user) {
			$user->phones()->saveMany(UserPhone::factory()->count(mt_rand(1, 3))->make());
			$user->cars()->saveMany(Car::factory()->count(mt_rand(0, 3))->make());
		});
	}
}

