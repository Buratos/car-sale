<div class="col-6 col-md-4 col-lg-3 col-xl-5cols col-xxl-2 ps-0 ps-sm-0 pe-2 pe-sm-2 mb-2 car_card_container">
	<div id="car_card{{$laptopId}}" class="card car_card" laptopid="{{$laptopId}}">
		@if($laptopPhotoUrl)
			<div class="card_photo_holder">
				<img src="{{$laptopPhotoUrl}}" class="card-img-top phone_card_photo" alt="laptop photo">
			</div>
		@else
			<div class="card_no_photo">{{__("NO PHOTO")}}</div>
		@endif
		<div class="card-body">
			<h6 class="car_name">{{$laptopTitle}}</h6>
			<h6 class="car_price">{{$laptopPrice}}</h6>
			<p class="d-none d-sm-block card-text car_parameters">{{$laptopDisplaySize}} / {{$laptopRamSsd}}</p>
			<p class="d-sm-none card-text car_parameters">{{$laptopDisplaySize}}</p>
			<p class="d-sm-none card-text car_parameters">{{$laptopRamSsd}}</p>
		</div>
		<label class="car_card_icons icon_compare">
			<input {{$isCompareIconChecked}} type="checkbox" class="input_compare" laptopid="{{$laptopId}}">
			<div class="icons">
				<svg  width="1.15rem" height="1.15rem">
					<use xlink:href="#i_compare"></use>
				</svg>
				<svg  width="1.15rem" height="1.15rem">
					<use xlink:href="#i_compare_on"></use>
				</svg>
			</div>
		</label>
		<label class="car_card_icons icon_favorite">
			<input {{$isFavoriteIconChecked}} type="checkbox" class="input_favorite" laptopid="{{$laptopId}}">
			<div class="icons">
				<svg  width="1.15rem" height="1.15rem">
					<use xlink:href="#i_favorite"></use>
				</svg>
				<svg  width="1.15rem" height="1.15rem">
					<use xlink:href="#i_favorite_on"></use>
				</svg>
			</div>
		</label>
	</div>
</div>
