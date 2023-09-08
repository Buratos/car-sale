function multiple_requests_in_one_request() {
	$table = "App\Models\Car\Car";
	dump(DB::query()
		->selectSub($table::query()->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
		->selectSub($table::query()->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
		->selectSub($table::query()->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
		->get()->toArray());
	dump(DB::query()
		->selectSub(Car::query()->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
		->selectSub(Car::query()->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
		->selectSub(Car::query()->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
		->get()->toArray());
	dd(DB::query()
		->selectSub(DB::table("cars")->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
		->selectSub(DB::table("cars")->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
		->selectSub(DB::table("cars")->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
		->get()->toArray());
}
