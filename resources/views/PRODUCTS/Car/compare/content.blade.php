<div class="container no_cars_in_compare {{$cars->count() ? "d-none" : ""}}">
	<div class="row">
		<div class="col d-flex justify-content-center ">
			<span class="fs-2 fw-bolder" style="line-height: 20rem;">No cars in comparison</span>
		</div>
	</div>
</div>
<div class="content {{$cars->count() ? "" : "d-none"}}">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-9 col-sm-5 col-md-4 mt-2 mt-sm-3 mb-2 mb-sm-3">
				<a id="clear_compare" class="w-100 btn btn-outline-secondary lh-sm ">{{__("Clear comparison")}}</a>
			</div>
		</div>
	</div>
	<section class="cd-products-comparison-table">
		<div class="cd-products-table">
			<div class="features">
				<div class="top-info">{{mb_strtoupper(__("Title"))}}</div>
				<ul class="cd-features-list">
					<li>{{__("Price")}}</li>
					<li>{{__("Production year")}}</li>
					<li>{{__("Body type")}}</li>
					<li>{{__("Color")}}</li>
					<li>{{__("Gearbox")}}</li>
					<li>{{__("Engine type")}}</li>
					<li>{{__("Engine capacity")}}</li>
					<li>{{__("Engine power")}}</li>
					<li>{{__("Fuel consumption")}}</li>
					<li>{{__("Clearance")}}</li>
					<li>{{__("Wheelbase")}}</li>
					<li>{{__("Number doors")}}</li>
					<li>{{__("Number places")}}</li>
					<li>{{__("Length")}}</li>
					<li>{{__("Width")}}</li>
					<li>{{__("Height")}}</li>
					<li><? echo app()->getLocale() == "ru" ? __("Mileage, km") : __("Mileage, m"); ?></li>
					<li>{{__("Was in accident")}}</li>
				</ul>
			</div> <!-- .features -->
			<div class="cd-products-wrapper">
				<ul class="cd-products-columns">
					@foreach($cars as $car)
							<?php
							$URLforCard = route("car.view", [$car->id]);
							$carId = $car->id;
							$carPhotoURL = asset(Storage::disk("public")->url("cars_photos/" . $car->photos[0]->filename));
							$carPrice = number_format($car->price, 0, "", " ") . " $";
							if (app()->getLocale() == "ru") $carMileage = number_format( $car->mileage, 0, "", " ");
							else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ");
							[$colorName, $colorValue] = explode("--", $car->color->name);
							?>
						<li class="product">
							<div class="top-info">
								<span class="d-none d-sm-inline btn_delete_compare_elem" data-func="delete_compare_elem" carid="{{$carId}}">
									<svg width="1rem" height="1rem">
										<use xlink:href="#i_close_mini"></use>
									</svg>
								</span>
								<a class="d-sm-none btn_delete_compare_elem" data-func="delete_compare_elem" carid="{{$carId}}">
										<svg  width="1.15rem" height="1.15rem">
											<use xlink:href="#i_close_circle"></use>
										</svg>
										<svg class="i_close_circle_filled" width="1.15rem" height="1.15rem">
											<use xlink:href="#i_close_circle_filled"></use>
										</svg>
									</a>
								<a href="{{$URLforCard}}" class="nav-link w-100 h-100 position-relative ">
									<div class="top_info_img_wrapper">
										<img src="{{$carPhotoURL}}" alt="product image">
									</div>
									<h3>{{$car->fullName}}</h3>
								</a>
							</div> <!-- .top-info -->
							<ul class="cd-features-list">
								<li>{{$carPrice}}</li>
								<li>{{$car->production_year}}</li>
								<li>{{__($car->bodyType->name)}}</li>
								<li>
									<color class="{{$colorValue == "#FFFFFF" ? "color_write_compare" : ""}}" style="background-color: {{$colorValue}};"></color>
									<span>{{__($colorName)}}</span>
								</li>
								<li>{{__($car->gearbox->name)}}</li>
								<li>{{__($car->engineType->name)}}</li>
								<li>{{$car->engine_capacity}}</li>
								<li>{{$car->engine_power}}</li>
								<li>{{$car->fuel_consumption}}</li>
								<li>{{$car->clearance}}</li>
								<li>{{$car->wheelbase}}</li>
								<li>{{$car->number_doors}}</li>
								<li>{{$car->number_places}}</li>
								<li>{{$car->length}}</li>
								<li>{{$car->width}}</li>
								<li>{{$car->height}}</li>
								<li>{{$carMileage}}</li>
								<li>{{$car->was_in_accident ? __("Yes") : __("No")}}</li>
							</ul>
						</li>
					@endforeach
				</ul> <!-- .cd-products-columns -->
			</div> <!-- .cd-products-wrapper -->
			<ul class="cd-table-navigation">
				<li>
					<a href="#0" class="prev inactive">Prev</a>
				</li>
				<li>
					<a href="#0" class="next">Next</a>
				</li>
			</ul>
		</div> <!-- .cd-products-table -->
	</section>
</div>