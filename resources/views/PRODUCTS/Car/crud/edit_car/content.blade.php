<script type="text/javascript">
  $myApp.carModels = <?php echo json_encode($models) ?>;
  $myApp.dictDefaultMessage = isMobileViewport() ? "{{__("Click here to select photos to upload")}}" : "{{__("Drop photos here to upload")}}"
</script>{{--                Общее сообщение об ошибке                       --}}
<div id="error_holder" class="content container-fluid container-md pt-0 pb-0 d-none">
	<div class="row">
		<div class="col">
			<div class="alert alert-dark error_message">
				<svg width="2.15rem" height="2.15rem">
					<use xlink:href="#i_error_circle_filled"></use>
				</svg>
				<span class="error_text"></span>
			</div>
		</div>
	</div>
	<i class="error_message_unknown d-none">{{__("Something went wrong. We don't know what yet. Failed to create your ad. You can try again")}}</i>
	<i class="error_message_some_input_invalid d-none">{{__("The entered data is incorrect or missing. Correct it please")}}</i>
	<i class="error_message_no_photos d-none">{{__("There are no photos. Upload photos please")}}</i>
</div><?php
      $id_for_link_form_and_uploaded_photos = old("id_for_link_form_and_uploaded_photos") ?? Str::uuid();
      ?>
<div class="content container-fluid container-md pt-3 pb-3">
	{{--**************************************************************--}}
	<div class="row mt-1 mb-3">
		<h2 class="text-center fw-bold">{{__("Edit an ad")}}</h2>
	</div>
	<?php
	$value["photo_filenames"] = old("photo_filenames") ?? "";
	$value["car_brand"] = old("car_brand") ?? $car->brand;
	$value["car_model"] = old("car_model") ?? $car->model;
	$value["car_gearbox"] = old("car_gearbox") ?? $car->gearbox->name;
	$value["car_engine_type"] = old("car_engine_type") ?? $car->engineType->name;
	$value["car_engine_capacity"] = old("car_engine_capacity") ?? $car->engine_capacity;
	$value["car_engine_power"] = old("car_engine_power") ?? $car->engine_power;
	$value["car_fuel_consumption"] = old("car_fuel_consumption") ?? round($car->fuel_consumption, 1);
	$value["car_body_type"] = old("car_body_type") ?? old("car_body_type") ?? $car->bodyType->name;
	$value["car_number_doors"] = old("car_number_doors") ?? $car->number_doors;
	$value["car_number_places"] = old("car_number_places") ?? $car->number_places;
	$value["car_color"] = old("car_color") ?? $car->color->name;
	$value["car_clearance"] = old("car_clearance") ?? $car->clearance;
	$value["car_wheelbase"] = old("car_wheelbase") ?? $car->wheelbase;

	$value["car_length"] = old("car_length") ?? $car->length;
	$value["car_width"] = old("car_width") ?? $car->width;
	$value["car_height"] = old("car_height") ?? $car->height;
	$value["car_production_year"] = old("car_production_year") ?? $car->production_year;
	$value["car_mileage"] = old("car_mileage") ?? $car->mileage;
	$value["car_was_in_accident"] = old("car_was_in_accident") ?? $car->was_in_accident;
	$value["car_price"] = old("car_price") ?? $car->price;
	$value["car_description"] = old("car_description") ?? $car->description;
	?>
	
	{{--****************** DESCRIBE YOUR CAR ************************--}}
	<div class="row car_list">
		<!--♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦-->
		<form action="/edit_car" method="PUT" class="add_new_car_form" enctype="multipart/form-data" id="edit_form">
			@csrf
			<input type="hidden" name="id_for_link_form_and_uploaded_photos" value="{{$id_for_link_form_and_uploaded_photos}}">
			<input type="hidden" name="photo_filenames" value='{{$value["photo_filenames"]}}'> {{--  to know the sequence of photos - 1,2,3,4 ....  --}}
			{{----}}
			<div class="col-12 text-center"> {{-- buttons  SEND & CLEAR DATA --}}
				<button type="submit" class="btn btn-outline-dark btn_send_data me-3">{{__("Save")}}</button>
				<a class="btn btn-outline-danger btn_clear_data" type="button">{{__("Clear data")}}</a>
			</div>
			<x-window_colored_title title='{{__("Describe your car")}}' color="green">
				<div class="row justify-content-center">
					<!--  -->
					<div class="col-12 col-sm-6 col-lg-4 col">
						<x-select_with_label name="car_brand" title='{{__("Car brand")}}' :options="$brands" value="{{$value['car_brand']}}" required/>
					</div>
					{{--
										<div class="col-12 col-sm-6 col-lg-4">
											<x-select_with_label name="car_model" title='{{__("Car model")}}' :options='["select brand"]' disabled/>
										</div>
					--}}
					<div class="col-12 col-sm-6 col-lg-4">
						<script type="text/javascript">
              $myApp.carModels = <?php echo json_encode($models) ?>;
						</script>
						<div class="form-group">
							<label for="car_model">{{__("Car model")}}</label>
							<input id="car_model" name="car_model" type="search" class="form-control" placeholder="{{__("Input or select model")}}" aria-label="{{__("Input or select model")}}" autocomplete="off" list="car_model_list" value="{{$value["car_model"]}}" required>
							<datalist id="car_model_list">
								<?php
								$firstBrandModels = $models[$value["car_brand"]];
								?>
								@foreach($firstBrandModels as $model)
									<option value="{{$model}}"></option>
								@endforeach
							</datalist>
						</div>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-select_with_label name="car_gearbox" title='{{__("Gearbox")}}' :options="$gearboxes" value="{{$value['car_gearbox']}}" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-select_with_label name="car_engine_type" title='{{__("Car engine type")}}' :options="$engineTypes" value="{{$value['car_engine_type']}}" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_engine_capacity" title='{{__("Engine capacity")}}' type="number" placeholder="{{__('Input engine capacity')}}" value='{{$value["car_engine_capacity"]}}'{{-- min="500" max="11000" required--}}/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_engine_power" title="{{__('Engine power')}}" type="number" placeholder="{{__('Input engine power')}}" value="{{$value['car_engine_power']}}" min="20" maxlength="2000" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4 ">
						<x-input_with_label name="car_fuel_consumption" title="{{__('Fuel consumption')}}" type="number" step="0.1" placeholder="{{__('Input mixed fuel consumption')}}" value="{{$value['car_fuel_consumption']}}" min="0" max="50" required/>
					</div>
				</div>
			</x-window_colored_title>
			{{--****************** CAR BODY ************************--}}
			<x-window_colored_title title='{{__("Car body")}}' color="blue">
				<div class="row ">
					<div class="col-12 col-sm-6 col-lg-7 col-xl-9">
						<x-select_with_label name="car_body_type" title='{{__("Body type")}}' :options='$bodyTypes' value="{{$value['car_body_type']}}" required/>
						<x-input_with_label name="car_number_doors" title='{{__("Number of doors")}}' type="number" placeholder="{{__('Input number of doors')}}" value="{{$value['car_number_doors']}}" min="2" max="5" required/>
						<x-input_with_label name="car_number_places" title="{{__('Number of places')}}" type="number" placeholder="{{__('Input number of places in a car')}}" value="{{$value['car_number_places']}}" min="1" max="10" required/>
					</div>
					<div class="col-12 col-sm-6 col-lg-5 col-xl-3 ">
						<x-color-selection :colors='$colors' value="{{$value['car_color']}}" required/>
					</div>
				</div>
			</x-window_colored_title>
			{{--****************** CAR DIMENSIONS ************************--}}
			<x-window_colored_title title='{{__("Dimensions")}}' color="red">
				<div class="row justify-content-center">
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_clearance" title='{{__("Ground clearance")}}' type="number" placeholder="{{__('Input clearance, mm')}}" value="{{$value['car_clearance']}}" min="50" max="500" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_wheelbase" title='{{__("Wheelbase")}}' type="number" placeholder="{{__('Input wheelbase, mm')}}" value="{{$value['car_wheelbase']}}" min="700" max="5000" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_length" title='{{__("Length")}}' type="number" placeholder="{{__('Input length, mm')}}" value="{{$value['car_length']}}" min="1500" max="7000" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_width" title='{{__("Width")}}' type="number" placeholder="{{__('Input width, mm')}}" value="{{$value['car_width']}}" min="500" max="3000" required/>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-lg-4">
						<x-input_with_label name="car_height" title="{{__('Height')}}" type="number" placeholder="{{__('Input height, mm')}}" value="{{$value['car_height']}}" min="700" max="2500" required/>
					</div>
				</div>
			</x-window_colored_title>
			{{--****************** MISCELLANEOUS ************************--}}
			<x-window_colored_title title='{{__("Miscellaneous")}}' color="yellow">
				<div class="row justify-content-center">
					<div class="col-12 col-sm-6 col-md-6">
						<div class="row">
							<div class="col-12">
								<x-input_with_label name="car_production_year" title='{{__("Production year")}}' type="number" placeholder="{{__('Input production year')}}" value="{{$value['car_production_year']}}" min="1900" max="2035" required/>
							</div>
							{{--                                                                   --}}
							<div class="col-12">
								<x-input_with_label name="car_mileage" title='{{__("Car mileage, km")}}' type="number" placeholder="{{__('Input mileage, km')}}" value="{{$value['car_mileage']}}" min="1" max="10000000" required/>
							</div>
							{{--                                                                   --}}
							<div class="col-12 d-flex flex-wrap justify-content-center">
								<div class="mt-3 me-2 mb-3">{{__("Was a car in an accident ?")}}</div>
								<div>
									<input {{$value["car_was_in_accident"] ? "" : "checked"}} id="car_was_in_accident_no" class="btn-check" name="car_was_in_accident" type="radio" value="0" autocomplete="off">
									<label for="car_was_in_accident_no" class="btn btn-outline-secondary btn-sm me-2 my-2" style="line-height: 1.1;">{{__("No")}}</label>
									<input {{$value["car_was_in_accident"] ? "checked" : ""}} id="car_was_in_accident_yes" class="btn-check" name="car_was_in_accident" type="radio" value="1" autocomplete="off">
									<label for="car_was_in_accident_yes" class="btn btn-outline-primary btn-sm my-2" style="line-height: 1.1;">{{__("Yes")}}</label>
								</div>
							</div>
							{{--                                                                   --}}
							<div class="col-12">
								<x-input_with_label name="car_price" title='{{__("Price, $")}}' type="number" placeholder="{{__('Input price, $')}}" value="{{$value['car_price']}}" min="1" max="10000000" required/>
							</div>
						</div>
					</div>
					{{--                                                                   --}}
					<div class="col-12 col-sm-6 col-md-6">
						<div class="form-group d-flex flex-wrap justify-content-center">
							<label for="car_description" class="flex-grow-1 align-items-start">{{__("Description for your car")}}</label>
							<textarea class="form-control flex-grow-1 align-items-stretch" placeholder="{{__('Input car description')}}" name="car_description" id="car_description" rows="8" minlength="0" maxlength="4000" required>{{$value["car_description"]}}</textarea>
						</div>
					</div>
				</div>
			</x-window_colored_title>
			<x-window_colored_title title='{{__("Photos")}}' color="green">
				<div id="error_photos" class="alert alert-dark error_message d-none"> {{-- error message --}}
					<svg width="2.15rem" height="2.15rem">
						<use xlink:href="#i_error_circle_filled"></use>
					</svg>
					<span>{{__("You have to upload at least one photo")}}</span>
				</div>
				{{--          DROPZONE                                                  --}}
				<div id="dropzone_placement" class="dropzone_placement dropzone">
					<?php
					$photos = [];
					foreach ($car->photos as $index => $photo) {
						$onePhoto = (object)[];
						$onePhoto->url = asset(Storage::disk("public")->url("cars_photos/" . $photo->filename));
						$onePhoto->filename = $photo->filename;
						$photos[] = $onePhoto;
					}
					?>
					@foreach($photos as $photo)
						<x-dz-preview :photo="$photo"/>
					@endforeach
				</div>
			</x-window_colored_title>
			<div class="col-12 text-center">  {{-- buttons  SEND & CLEAR DATA --}}
				<button type="submit" class="btn btn-outline-dark btn_send_data me-3">{{__("Save")}}</button>
				<a class="btn btn-outline-danger btn_clear_data" type="button">{{__("Clear data")}}</a>
			</div>
		</form>
	</div>
</div>
<div class="storage d-none">
	<div class="drag_drop_big_icon">
		<svg class="" width="4rem" height="4rem">
			<use xlink:href="#i_drag_drop"></use>
		</svg>
	</div>
</div>
<x-modal_wait_for_saving_product/>