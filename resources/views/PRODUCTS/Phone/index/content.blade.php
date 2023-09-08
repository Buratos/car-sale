<div class="content container pt-0 pb-1">
	<div class="row paginator_container">
		<div class="col-12 text-center">
			{{$phones->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
	<div class="row sorting_and_per_page mt-2 mb-1">
		<div class="col-12 col-sm-auto text-center">
			<x-select_sort_mode :sortModesAndTexts="$sortModesAndTexts" :sortMode="$sortMode"/>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<x-select_elems_per_page_15_20_30_50_100 :currentPerPage="$phones->perPage()"/>
		</div>
	</div>
	<div class="row car_list">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-2 pt-sm-0 car_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($phones as $phone)
					<?php
					$phoneId = $phone->id;
					$phonePhotoUrl = $phone->getPhotoUrl();
					$phonePrice = number_format($phone->price, 0, "", " ") . " $";
					$phoneDisplaySize = $phone->display_size . '"';
					$phoneRamStorage = $phone->ram . " / " . $phone->storage;
					$isFavoriteIconChecked = in_array($phoneId, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($phoneId, $compareElems) ? " checked " : "";
					?>
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}
				<x-phone_card :phoneId="$phoneId" :phonePhotoUrl="$phonePhotoUrl" :phoneTitle="$phone->fullName" :phonePrice="$phonePrice" :phoneDisplaySize="$phoneDisplaySize" :phoneRamStorage="$phoneRamStorage" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
			@endforeach
		</div>
	</div>
	<div class="row sorting_and_per_page mt-0 mb-2">
		<div class="col-12 col-sm-auto text-center">
			<x-select_sort_mode :sortModesAndTexts="$sortModesAndTexts" :sortMode="$sortMode"/>
		</div>
		<div class="col-12 col-sm-auto text-center">
			<x-select_elems_per_page_15_20_30_50_100 :currentPerPage="$phones->perPage()"/>
		</div>
	</div>
	<div class="row ">
		<div class="col-12 text-center mt-1 mb-2 mb-sm 3 ">
			{{$phones->withQueryString()->onEachSide(0)->links("vendor.pagination.car_content_BS5")}}
		</div>
	</div>
</div><!-- ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
