<?php
$categories = [["title"     => "Cars",
                "url"       => route("cars.index"),
                "photo_url" => asset("img/categories/cars_color.webp")],
               ["title"     => "Laptops",
                "url"       => route("laptops.index"),
                "photo_url" => asset("img/categories/laptops_color.webp")],
               ["title"     => "Phones",
                "url"       => route("phones.index"),
                "photo_url" => asset("img/categories/phones_color.webp")],
               ["title"     => "SSDs",
                "url"       => route("ssds.index"),
                "photo_url" => asset("img/categories/ssds_color.webp")]];

?>
<div class="content container">
	<div class="row justify-content-center">
		<div class="col-12 mt-4 mb-2 mt-sm-4 mb-sm-4">
			<div class="alert alert-warning text-center mt-2 mb-0 lh-base alert_black_white" role="alert">
				{{__("Category selection message")}}
			</div>
		</div>
	</div>
	<div class="row justify-content-center {{--mt-1 mb-4 mx-0 mx-sm-3--}} category_selection_holder">
		@foreach($categories as $category)
			<x-category_card title='{{__($category["title"])}}' urlForCard='{{$category["url"]}}' categoryPhotoUrl='{{$category["photo_url"]}}'/>
		@endforeach
	</div>
</div>