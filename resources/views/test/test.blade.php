@extends("test.layout")

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
		{{--     JQuery      --}}
		<script src="{{asset('/plugins/jquery-3.7.0.min.js')}}" type="text/javascript"></script>
		{{--  --}}
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		{{--	for debugging --}}
		@if (config('app.debug'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
		{{--		<link href="fontawesome/css/fontawesome_all.min.css" rel="stylesheet">--}}
	</head>
@endsection


@section("content")
	{{-- CONTENT --}}
	<content>
		@include("test.content")
	</content>
@endsection


