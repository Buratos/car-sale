<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller {
	public function index() {
		return ProductCategory::all();
	}

	public function store(Request $request) {
		$request->validate([

		]);

		return ProductCategory::create($request->validated());
	}

	public function show(ProductCategory $productCategory) {
		return $productCategory;
	}

	public function update(Request $request, ProductCategory $productCategory) {
		$request->validate([

		]);

		$productCategory->update($request->validated());

		return $productCategory;
	}

	public function destroy(ProductCategory $productCategory) {
		$productCategory->delete();

		return response()->json();
	}
}
