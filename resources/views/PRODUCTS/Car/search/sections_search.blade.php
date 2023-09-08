@extends("PRODUCTS.Car.search.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		@include("common_sections.meta_tags")
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,18) . '.png')}}" type="image/x-icon">
		<title>{{$page_title ?? "CAR SALE"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/main__index.js')}}" type="module"></script>
		{{--	для фильтров Ion.RangeSlider  https://github.com/IonDen/ion.rangeSlider  https://jsfiddle.net/IonDen/avcm6wpj/  --}}
		<link href="{{asset('/admin/plugins/ion-rangeslider/css/ion.rangeSlider__my_mod.css')}}" rel="stylesheet">
		<script src="{{asset('/admin/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
		{{--  --}}
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/btn_checkbox.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/filters.css')}}" rel="stylesheet"/>
		{{--	for debugging --}}
		@if (config('app.debug'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
	</head>
@endsection

@section("header__logo_search_auth_menu")
	{{-- header__logo_search_auth_menu --}}
	@include("common_sections.header__logo_search_auth_menu")
@endsection

@section("brands_menu")
	{{-- BRANDS MENU --}}
	@include("PRODUCTS.Car.common_sections.brands_menu")
@endsection

@section("filters")
	{{-- FILTERS --}}
	@include("PRODUCTS.Car.common_sections.filters")
@endsection

@section("message_above_content")
	{{-- SEARCH_MESSAGE --}}
	@include("PRODUCTS.Car.search.message_above_content")
@endsection

@section("content")
	{{-- CONTENT --}}
	<content>
		@include("PRODUCTS.Car.index.content")
	</content>
@endsection

@section("footer")
	{{-- FOOTER --}}
	@include("common_sections.footer")
@endsection

@section("switch_language")
	{{-- SWITCH LANGUAGE --}}
	@include("common_sections.switch_language")
@endsection

@section("storage__svg_icons")
	@include("common_sections.storage__svg_icons")
@endsection


