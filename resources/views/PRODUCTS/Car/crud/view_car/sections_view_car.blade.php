@extends("PRODUCTS.Car.crud.view_car.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,18) . '.png')}}" type="image/x-icon">
		<title>{{$page_title ?? "CAR SALE"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/main__view_car.js.js')}}" type="module"></script>
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/plugins/photo_slider/css/photo_slider_for_mobile.css')}}" rel="stylesheet"/>
		<link href="{{asset('/plugins/photo_slider/css/photo_slider_for_desktop.css')}}" rel="stylesheet"/>
		<script src="{{asset('/plugins/photo_slider/js/photoslider.js')}}" type="text/javascript"></script>
		{{--  --}}
		<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/view_car.css')}}" rel="stylesheet"/>
		<script src="{{asset('/js/search.js')}}" type="text/javascript"></script>
		{{--	for debugging --}}
		@if (config('app.debug'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
		{{--		<link href="fontawesome/css/fontawesome_all.min.css" rel="stylesheet">--}}
	</head>
@endsection

@section("header__logo_search_auth_menu")
	{{-- header__logo_search_auth_menu --}}
	@include("common_sections.header__logo_search_auth_menu")
@endsection

@section("content")
	{{-- CONTENT --}}
	<content>
		@include("PRODUCTS.Car.crud.view_car.content")
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


