@extends("layouts.admin._page_carcass_")@section("title","+++++++ Index | Dashboard")
@section("head")
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,18) . '.png')}}" type="image/x-icon">
	<title>{{$page_title ?? "CAR SALE"}}</title>
	{{--	BOOTSTRAP --}}
	<link href="{{asset('/plugins/bootstrap-5/css/bootstrap.css')}}" rel="stylesheet">
	<script src="{{asset('/plugins/bootstrap-5/js/bootstrap.bundle.min.js')}}"></script>
	{{--  --}}
	<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
	<link href="{{asset('/css/style.css')}}" rel="stylesheet"/>
	<script src="{{asset('/plugins/jquery-3.7.0.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/search.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
	{{--	for debugging --}}
	@if (config('app.debug'))
		<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
		<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
	@endif
	<!--
		<link href="fontawesome/css/fontawesome_all.min.css" rel="stylesheet">
	-->
@endsection
@section("content")
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item">
								<a href="#">Home</a>
							</li>
							<li class="breadcrumb-item active">Dashboard v1</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					@include("main_carcass.brands_menu")       {{--▪▪▪ МЕНЮ  ИКОНОК  БРЭНДОВ  ▪▪▪--}}
					@include('main_carcass.filters')           {{--▪▪▪ ФИЛЬТРЫ  FILTERS ▪▪▪--}}
					@include('main_page.default_content')
				</div>
				<div class="row"></div>
			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
@endsection

@section("page_scripts")
	<!-- jQuery -->
	<script src="{{asset('/admin/plugins/jquery/jquery.min.js')}}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('/admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
    $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- ChartJS -->
	<script src="{{asset('/admin/plugins/chart.js/Chart.min.js')}}"></script>
	<!-- Sparkline -->
	<script src="{{asset('/admin/plugins/sparklines/sparkline.js')}}"></script>
	<!-- JQVMap -->
	<script src="{{asset('/admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('/admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{asset('/admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
	<!-- daterangepicker -->
	<script src="{{asset('/admin/plugins/moment/moment.min.js')}}"></script>
	<script src="{{asset('/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{asset('/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
	<!-- Summernote -->
	<script src="{{asset('/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
	<!-- overlayScrollbars -->
	<script src="{{asset('/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('/admin/dist/js/adminlte.js')}}"></script>
	<!-- AdminLTE for demo purposes -->
	{{--	<script src="{{asset('/admin/dist/js/demo.js')}}"></script>--}}
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	{{--	<script src="{{asset('/admin/dist/js/pages/dashboard.js')}}"></script>--}}

@endsection