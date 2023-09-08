@extends("PRODUCTS.Car.crud.edit_car.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,18) . '.png')}}" type="image/x-icon">
		<title>{{$page_title ?? "CAR SALE"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		<!-- DRAG DROP FILES-->
		<x-sortable_2_plugins/>
		<x-dropzone_and_my_mod/>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/main__edit_car.js')}}" type="module"></script>
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/btn_checkbox.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/create_car.css')}}" rel="stylesheet"/>
		{{--	for debugging --}}
		@if (config('app.debug'))
			{{--						<script src="{{asset('/plugins/live_only_JS_and_CSS.js')}}" type="text/javascript"></script>--}}
			<script src="{{asset('/plugins/live_only_CSS.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
	</head>
@endsection

@section("header__logo_search_auth_menu")
	{{-- header__logo_search_auth_menu --}}
	@include("common_sections.header__logo_search_auth_menu")
@endsection

@section("content")
	{{-- CONTENT --}}
	<section class="content_global_wrapper">
		@include("PRODUCTS.Car.crud.edit_car.content")
	</section>
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


