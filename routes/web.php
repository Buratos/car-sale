<?php

use Illuminate\Support\Facades\Route;

// ****  PAGES  **************************************************
Route::group(["namespace" => "\App\Http\Controllers\Car"], function () {
	Route::get('/', "IndexController")->name("cars.index");
	Route::get('/latest', "LatestController")->name("cars.latest");
	Route::get('/search', "SearchController")->name("cars.search");
	Route::post('/search', "DynamicSearchController")->name("cars.dynamic_search");
	Route::get('/compare', "CompareController")->name("cars.compare");
	Route::get('/favorites', "FavoritesController")->name("cars.favorites");
	Route::get('/categories', function () { return view("category_selection.sections_categories"); })->name("categories");
//	Route::get('/forum', function () { return view("forum.sections_forum"); })->name("forum");
	Route::get('/view_car/{id}', "ViewController")->name("car.view");
	Route::post('/get_extended_product_card_micro_photos', "GetExtendedProductCardMicroPhotosController")->name("cars.get_extended_product_card_micro_photos");
	//                                                                    --
	Route::get('/create', "CreateController")->name("cars.create");/*->middleware("cars.create");*/
	Route::post('/create', "StoreController")->name("cars.store");/*->middleware("cars.create");*/
	Route::post('/photo-upload', "PhotoUploadController")->name("cars.photo-upload");/*->middleware("cars.create");*/
	Route::post('/delete-uploaded-photo', "DeleteUploadedPhotoController")->name("cars.delete-uploaded-photo");
//                                                                    --
	Route::get('/edit_car/{id}', "EditController")->name("cars.edit");/*->middleware("cars.update");*/
	Route::post('/edit_car/{id}', "UpdateController")->name("cars.update");/*->middleware("cars.update")*/;
	Route::get('/delete_car/{id}', "DeleteController")->name("cars.delete");/*->middleware("cars.update");*/
});

Route::group(["namespace" => "\App\Http\Controllers\Laptop"], function () {
	Route::get('/laptops/', "IndexController")->name("laptops.index");
});

Route::group(["namespace" => "\App\Http\Controllers\Phone"], function () {
	Route::get('/phones/', "IndexController")->name("phones.index");
});

Route::group(["namespace" => "\App\Http\Controllers\Ssd"], function () {
	Route::get('/ssds/', "IndexController")->name("ssds.index");
});

// ▪▪▪▪  FILTERS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/create_filters', [\App\Http\Controllers\FilterController::class, "index"]);
Route::post('/calculate_filters', [\App\Http\Controllers\FilterController::class, "carsCalculateFilters"]);
Route::post('/laptops/calculate_filters', [\App\Http\Controllers\FilterController::class, "laptopsCalculateFilters"]);
Route::post('/phones/calculate_filters', [\App\Http\Controllers\FilterController::class, "phonesCalculateFilters"]);
Route::post('/ssds/calculate_filters', [\App\Http\Controllers\FilterController::class, "ssdsCalculateFilters"]);

// ▪▪▪▪  ERRORS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::group(["namespace" => "\App\Http\Controllers", "prefix" => "error"], function () {
	Route::get('/', "ErrorController@noPermission")->name("error.no_permission");
	Route::get('/', "ErrorController@cantCreateNewAd")->name("error.cant_create_new_ad");
});

// ▪▪▪▪  MESCELLANIOUS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/lang/{lang}', ["as" => "lang.switch", "uses" => "\App\Http\Controllers\LanguageController@swithLang"]);

// ▪▪▪▪  DEBUG  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
if (config('app.debug')) {
	Route::get('/test', "\App\Http\Controllers\Test");
	// для postman
	Route::get('/test_get', "\App\Http\Controllers\Test@postman")->name("cars.store");/*->middleware("cars.create");*/
//	Route::get('/adminlte_source', \App\Http\Controllers\Admin\AdminlteSourceController::class)->name("admin_source.index");
//	Route::get('/dd', function () { return view("test.dd"); })->name("dd");
//	clear_logs__for_debug();
}

// ▪▪▪▪  ADMIN PANEL  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::group(["namespace" => "\App\Http\Controllers\Admin",/* "prefix" => "admin",*/ "middleware" => "users_role_check"], function () {
	/*	Route::group(["namespace" => "Car"], function () {
			Route::get('/admin/car', IndexController::class)->name("admin.cars.index");
		});*/
	Route::get('/admin/car', function () { return "admin.cars.index"; })->name("admin.cars.index");
	Route::get('/admin', function () {
		return redirect()->route("admin.cars.index");
	});
	Route::get('/dashboard', function () {
		return redirect()->route("admin.cars.index");
	});
});

