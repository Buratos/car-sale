<div class="content container">
	<div class="row">
		<div class="col">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{route('cars.index')}}">{{__("Home")}}</a>
					</li>
					<li class="breadcrumb-item">
						<a href="{{route('cars.index', ['ff' => $brandFilterCode])}}">{{$car->brand}}</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">{{$car->fullName}}</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-12 px-0 px-sm-2 col-md-8 photos_slider">
			<div class="photoslider">
				<div class="photoslider_inner">
					<div class="photoslider_items_holder">
						<?php
						$carPrice = number_format($car->price, 0, "", " ");
						if (app()->getLocale() == "ru") $mileage = number_format($car->mileage, 0, "", " ");
						else $mileage = number_format(floor($car->mileage / 1.609), 0, "", " ");
						$photos = [];
						foreach ($car->photos as $index => $photo) {
							$onePhoto = (object)[];
							$onePhoto->url = asset(Storage::disk("public")->url("cars_photos/" . $photo->filename));
							$onePhoto->title = "Photo " . ($index + 1);
							$onePhoto->description = $photo->description;
							$photos[] = $onePhoto;
						}
						if (count($photos)) {
							//							чтобы работало круговое зацикливание фоток кнопками <>, надо в начало добавить
							//							последнюю фотку, а в конец первую
							$firstPhoto = $photos[0];
							$lastPhoto = $photos[count($photos) - 1];
							array_unshift($photos, $lastPhoto);
							$photos[] = $firstPhoto;
						}
						?>
						@foreach($photos as $photo)
								<?php
								if ($loop->index == 0) $someClass = " margin_left_phone ";
								else if ($loop->index == 1) $someClass = " left0 active ";
								else $someClass = "";
								?>
							<div class="photoslider-item {{$someClass}}" number="{{$loop->index}}">
								<div class="photoslider-image" style="background-image: url({{$photo->url}});"></div>
								<div class="photoslider-item-title-and-text">
									<span>{{$photo->title}}</span><br>
									<span class="d-none">{{$photo->description}}</span>
								</div>
							</div>
						@endforeach
						<div class="btn-photoslider-prev phone_mode">
							<div>
								<svg viewBox="0 0 256 512">
									<path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
								</svg>
							</div>
						</div>
						<div class="btn-photoslider-next phone_mode">
							<div>
								<svg viewBox="0 0 256 512">
									<path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"/>
								</svg>
							</div>
						</div>
					</div>
				</div>
				<div class="photoslider_miniitem_set ">
					<div class="btn-photoslider-prev-mini">
						<div>
							<svg viewBox="0 0 256 512">
								<path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
							</svg>
						</div>
					</div>
					<div class="photoslider_miniitems_wrapper">
						<div class="photoslider_miniitems_holder">
							<?php
							$photos = array_slice($photos, 1, count($photos) - 2);
							?>
							@foreach($photos as $photo)
									<?php
									$someClass = $loop->index == 0 ? "active_photoslider_mini_item" : "";
									?>
								<div class="photoslider-mini-item {{$someClass}}" number="{{$loop->index+1}}">
									<div style="background-image: url({{$photo->url}});"></div>
								</div>
							@endforeach
						</div>
					</div>
					<div class="btn-photoslider-next-mini">
						<div>
							<svg viewBox="0 0 256 512">
								<path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="photoslider_fullscreen" style="display:none;">
					<div class="fullscreen_slide_holder"></div>
					<div class="btn-photoslider-prev btn-photoslider-fullscr phone_mode">
						<div>
							<svg viewBox="0 0 256 512">
								<path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
							</svg>
						</div>
					</div>
					<div class="btn-photoslider-next btn-photoslider-fullscr phone_mode">
						<div>
							<svg viewBox="0 0 256 512">
								<path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"/>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 car_info">
			<h2 class="text-center fw-bold">{{$car->fullName}}</h2>
			<div class="table_wrapper2">
				<table id="view_car_table">
					<thead>
						<tr>
							<td></td>
						</tr>
					</thead>
					<tbody class="tbody">
						<tr>
							<td>{{__("Production year")}}</td>
							<td>{{$car->production_year}}</td>
						</tr>
						<tr>
							<td>{{__("Body type")}}</td>
							<td>{{__($car->bodyType->name)}}</td>
						</tr>
						<tr>
							<td>{{__("Gearbox")}}</td>
							<td>{{__($car->gearbox->name)}}</td>
						</tr>
						<tr>
							<td>{{__("Engine type")}}</td>
							<td>{{__($car->engineType->name)}}</td>
						</tr>
						<tr>
							<td>{{__("Engine capacity")}}</td>
							<td>{{$car->engine_capacity}}</td>
						</tr>
						<tr>
							<td>{{__("Engine power")}}</td>
							<td>{{$car->engine_power}}</td>
						</tr>
						<tr>
							<td>{{__("Mixed fuel cons.")}}</td>
							<td>{{$car->fuel_consumption}}</td>
						</tr>
						<tr>
							<td>{{__("Ground clearance")}}</td>
							<td>{{$car->clearance}}</td>
						</tr>
						<tr>
							<td>{{__("Wheelbase")}}</td>
							<td>{{$car->wheelbase}}</td>
						</tr>
						<tr>
							<td>{{__("Number of doors")}}</td>
							<td>{{$car->number_doors}}</td>
						</tr>
						<tr>
							<td>{{__("Number of places")}}</td>
							<td>{{$car->number_places}}</td>
						</tr>
						<tr>
							<td>{{__("Length")}}</td>
							<td>{{$car->length}}</td>
						</tr>
						<tr>
							<td>{{__("Width")}}</td>
							<td>{{$car->width}}</td>
						</tr>
						<tr>
							<td>{{__("Height")}}</td>
							<td>{{$car->height}}</td>
						</tr>
						<tr>
							<td><? echo app()->getLocale() == "ru" ? __("Mileage, km") : __("Mileage, m"); ?></td>
							<td>{{$mileage}}</td>
						</tr>
						<tr>
							<td>{{__("Was in accident")}}</td>
							<td>{{$car->was_in_accident ? __("Yes") : __("No")}}</td>
						</tr>
						<tr>
							<td>{{__("Price")}}</td>
							<td style="white-space: nowrap">{{$carPrice}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-12 car_description">
			<h4 class="text-center fw-bold">{{__("Description for your car")}}</h4>
			<div><?php
			     echo convert_to_html_paragraphs($car->description);
			     ?></div>
		</div>
		<div class="col-12 text-center d-flex flex-wrap justify-content-center">
			<a id="btn_edit_car" href="{{route("cars.edit",["id" => $car->id])}}" class="btn btn-outline-primary btn-sm me-3" {{--id="edit_car"--}} style="min-width: 7rem">{{__("Edit car")}}</a>
			<a id="btn_delete_car" href="{{route("cars.delete",["id" => $car->id])}}" class="btn btn-outline-danger btn-sm me-3" {{--id="delete_car"--}} style="min-width: 7rem">{{__("Delete car")}}</a>
			<a id="btn_add_to_favorites" href="#" class="btn btn-outline-success btn-sm me-3 favorite_icon" carid="{{$car->id}}" style="min-width: 7rem">{{__("Add to favorites")}}</a>
			<a id="btn_add_to_compare" href="#" class="btn btn-outline-warning btn-sm me-3 compare_icon" carid="{{$car->id}}" style="min-width: 7rem">{{__("Add to comparison")}}</a>
		</div>
	</div>
</div>