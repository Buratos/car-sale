{{--	BOOTSTRAP --}}
@if (config('app.debug'))
	<link href="{{asset('/plugins/bootstrap-5/css/bootstrap.css')}}" rel="stylesheet">
@else
	<link href="{{asset('/plugins/bootstrap-5/css/bootstrap.min.css')}}" rel="stylesheet">
@endif
<script src="{{asset('/plugins/bootstrap-5/js/bootstrap.bundle.min.js')}}"></script>
<link href="{{asset('/css/bootstrap_addition_5col.css')}}" rel="stylesheet">
