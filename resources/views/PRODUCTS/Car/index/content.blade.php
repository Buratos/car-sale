<div class="content container pt-0 pb-1">
	<div class="row paginator_container">
		<div class="col-12 text-center">
			{{$cars->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
	<div class="row sorting_and_per_page mt-2 mb-1">
		<div class="col-12 col-sm-auto text-center">
			<x-select_sort_mode :sortModesAndTexts="$sortModesAndTexts" :sortMode="$sortMode"/>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<x-select_elems_per_page_15_20_30_50_100 :currentPerPage="$cars->perPage()"/>
		</div>
	</div>
	<div class="row car_list">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-2 pt-sm-0 car_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($cars as $car)
					<?php
					$URLforCard = route("car.view", [$car->id]);
					$carId = $car->id;
					if ($car->photos->count()) $carPhotoURL = asset(Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[0]->filename, PATHINFO_FILENAME) . ".webp"));
					else $carPhotoURL = "";
					$carPrice = number_format($car->price, 0, "", " ") . " $";
					if (app()->getLocale() == "ru") $carMileage = number_format($car->mileage, 0, "", " ") . " " . __("km");
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
			<x-select_sort_mode :sortModesAndTexts="$sortModesAndTexts" :sortMode="$sortMode"/>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<x-select_elems_per_page_15_20_30_50_100 :currentPerPage="$cars->perPage()"/>
		</div>
	</div>
	<div class="row ">
		<div class="col-12 text-center mt-1 mb-2 mb-sm 3 ">
			{{$cars->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
</div><!-- ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
<div id="extCard_FOR_CLONE" class="card car_card extended_car_card d-none" card_id="">
	<a class="card_url position-relative" href="">
		<img src="" class="card-img-top ext_car_card_photo" style="border-radius: 0;" alt="car photo">
		<div class="ext_car_card_microphoto_set d-flex justify-content-between mt-2 mb-3 mx-2">
			@for ($i = 0; $i < 5; $i++)
				<div class="ext_card_empty_img"></div>
			@endfor
		</div>
		<div class="card-body pt-0 "></div>
		<div class="ext_card_footer">
			<span href="" class="btn btn-outline-success btn-sm" style="min-width: 6rem;line-height: 1.2;">{{__("Details")}}</span>
		</div>
	</a>
</div>