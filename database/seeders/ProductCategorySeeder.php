<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder {
	public function run(): void {
		$categories = [["table_name" => "laptops", "title" => "Laptops", "level" => 1, "belongs_to" => 0],
		               ["table_name" => "phones", "title" => "Mobile phones", "level" => 1, "belongs_to" => 0],
		               ["table_name" => "ssds", "title" => "SSDs", "level" => 1, "belongs_to" => 0],
		               ["table_name" => "cars", "title" => "Cars", "level" => 1, "belongs_to" => 0]];
		foreach ($categories as $category) {
			ProductCategory::insert($category);
		}
	}
}
