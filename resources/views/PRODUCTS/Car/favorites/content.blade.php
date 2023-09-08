<div class="container no_cars_in_favorits {{$cars->count() ? "d-none" : ""}}">
	<div class="row">
		<div class="col d-flex justify-content-center ">
			<span class="fs-2 fw-bolder" style="line-height: 20rem;">No cars in favorits</span>
		</div>
	</div>
</div>
<div class="content container pt-0 pb-1 {{$cars->count() ? "" : "d-none"}}">
	<div class="row justify-content-center">
		<div class="col-8 col-sm-5 col-md-4 mt-2 mb-2 mt-sm-3 mb-sm-2">
			<a id="clear_favorites" class="w-100 btn btn-outline-secondary lh-sm ">{{__("Clear favorites")}}</a>
		</div>
	</div>
	<?php
		$dnoneForPaginatorContainer = $cars->hasPages() ? "" : "d-none";
	?>
	<div class="row paginator_container {{$dnoneForPaginatorContainer}}">
		<div class="col-12 text-center">
			{{$cars->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
	<div class="row sorting_and_per_page mt-2 mb-1">
		<div class="col-12 col-sm-auto text-center">
			<label>{{__("Sort by")}}</label>
			<select id="sort_mode" class="form-select form-select-sm" aria-label=".form-select-sm пример">
				<option value="brand_asc" {{$sortMode == "brand_asc" ? "selected" : ""}}>{{__("Name ascending")}}</option>
				<option value="brand_desc" {{$sortMode == "brand_desc" ? "selected" : ""}}>{{__("Name descending")}}</option>
				<option value="year_asc" {{$sortMode == "year_asc" ? "selected" : ""}}>{{__("Year ascending")}}</option>
				<option value="year_desc" {{$sortMode == "year_desc" ? "selected" : ""}}>{{__("Year descending")}}</option>
				<option value="price_asc" {{$sortMode == "price_asc" ? "selected" : ""}}>{{__("Price ascending")}}</option>
				<option value="price_desc" {{$sortMode == "price_desc" ? "selected" : ""}}>{{__("Price descending")}}</option>
				<option value="latest" {{$sortMode == "latest" ? "selected" : ""}}>{{__("Latest")}}</option>
				<option value="oldest" {{$sortMode == "oldest" ? "selected" : ""}}>{{__("Oldest")}}</option>
				<option value="random" {{$sortMode == "random" ? "selected" : ""}}>{{__("Randomly")}}</option>
			</select>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<label>{{__("Per page")}}</label>
			<select id="elems_per_page" class="form-select form-select-sm" aria-label=".form-select-sm">
				<option value="15" {{$cars->perPage() == "15" ? "selected" : ""}}>15</option>
				<option value="20" {{$cars->perPage() == "20" ? "selected" : ""}}>20</option>
				<option value="30" {{$cars->perPage() == "30" ? "selected" : ""}}>30</option>
				<option value="50" {{$cars->perPage() == "50" ? "selected" : ""}}>50</option>
				<option value="100" {{$cars->perPage() == "100" ? "selected" : ""}}>100</option>
				<option value="200" {{$cars->perPage() == "200" ? "selected" : ""}}>200</option>
			</select>
		</div>
	</div>
	<div class="row car_list">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-2 pt-sm-0 car_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($cars as $car)
					<?php
					$URLforCard = route("car.view", [$car->id]);
					$carId = $car->id;
					$carPhotoURL = asset('/storage/cars_photos/' . $car->photos[0]->filename);
					$carPrice = number_format($car->price, 0, "", " ") . " $";
					if (app()->getLocale() == "ru") $carMileage = number_format( $car->mileage, 0, "", " ") . " " . __("km");
					else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ") . " " . __("m");
					$isFavoriteIconChecked = in_array($carId, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($carId, $compareElems) ? " checked " : "";
					?>
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}
				<x-car_card :url-for-card="$URLforCard" :car-id="$carId" :car-photo-url="$carPhotoURL" :car-title="$car->fullName" :car-price="$carPrice" :car-year="$car->production_year" :car-mileage="$carMileage" :is-favorite-icon-checked="$isFavoriteIconChecked" :is-compare-icon-checked="$isCompareIconChecked"/>
			@endforeach
		</div>
	</div>
	<div class="row sorting_and_per_page mt-0 mb-2">
		<div class="col-12 col-sm-auto text-center">
			<label>{{__("Sort by")}}</label>
			<select id="sort_mode" class="form-select form-select-sm" aria-label=".form-select-sm пример">
				<option value="brand_asc" {{$sortMode == "brand_asc" ? "selected" : ""}}>{{__("Name ascending")}}</option>
				<option value="brand_desc" {{$sortMode == "brand_desc" ? "selected" : ""}}>{{__("Name descending")}}</option>
				<option value="year_asc" {{$sortMode == "year_asc" ? "selected" : ""}}>{{__("Year ascending")}}</option>
				<option value="year_desc" {{$sortMode == "year_desc" ? "selected" : ""}}>{{__("Year descending")}}</option>
				<option value="price_asc" {{$sortMode == "price_asc" ? "selected" : ""}}>{{__("Price ascending")}}</option>
				<option value="price_desc" {{$sortMode == "price_desc" ? "selected" : ""}}>{{__("Price descending")}}</option>
				<option value="latest" {{$sortMode == "latest" ? "selected" : ""}}>{{__("Latest")}}</option>
				<option value="oldest" {{$sortMode == "oldest" ? "selected" : ""}}>{{__("Oldest")}}</option>
				<option value="random" {{$sortMode == "random" ? "selected" : ""}}>{{__("Randomly")}}</option>
			</select>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<label>{{__("Per page")}}</label>
			<select id="elems_per_page" class="form-select form-select-sm" aria-label=".form-select-sm">
				<option value="15" {{$cars->perPage() == "15" ? "selected" : ""}}>15</option>
				<option value="20" {{$cars->perPage() == "20" ? "selected" : ""}}>20</option>
				<option value="30" {{$cars->perPage() == "30" ? "selected" : ""}}>30</option>
				<option value="50" {{$cars->perPage() == "50" ? "selected" : ""}}>50</option>
				<option value="100" {{$cars->perPage() == "100" ? "selected" : ""}}>100</option>
				<option value="200" {{$cars->perPage() == "200" ? "selected" : ""}}>200</option>
			</select>
		</div>
	</div>
	<div class="row ">
		<div class="col-12 text-center mt-1 mb-2 mb-sm 3  {{$dnoneForPaginatorContainer}}">
			{{$cars->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
</div>