@extends("errors.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,18) . '.png')}}" type="image/x-icon">
		<title>{{$page_title ?? "CAR SALE"}}</title>
		{{--	BOOTSTRAP --}}
		<link href="{{asset('/plugins/bootstrap-5/css/bootstrap.css')}}" rel="stylesheet">
		<script src="{{asset('/plugins/bootstrap-5/js/bootstrap.bundle.js')}}"></script>
		{{--  --}}
		<script src="{{asset('/plugins/jquery-3.7.0.min.js')}}" type="text/javascript"></script>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/search.js')}}" type="text/javascript"></script>
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/error.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
		{{--	for debugging --}}
		@if (config('app.debug'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
		@endif
	</head>
@endsection

@section("header__logo_search_auth_menu")
	{{-- header__logo_search_auth_menu --}}
	@include("common_sections.header__logo_search_auth_menu")
@endsection

@section("content")
	{{-- CONTENT --}}
	<content>
		<div class="container">
			<div class="row">
				<div class="col error">
					<p class="error_title">{{__("ERROR :(")}}</p>
					<p class="error_text">{{__("Not Found")}}</p>
				</div>
			</div>
		</div>
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


