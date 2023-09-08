<div class="container-fluid px-3 text-bg-dark">
	<div class="row justify-content-center">
		<div class="col-auto switch_language_wrapper">
			<div class="current_lang_div">
				<span>{{__("Current language:")}}</span>
				<span>{{Config::get('languages')[App::getLocale()]}}</span>
			</div>
			<div class="another_lang_div">
				<span class="select_lang">{{__("Select language:")}}</span>
				@foreach (Config::get('languages') as $lang => $language)
					@if ($lang != App::getLocale())
						<a href="{{ route('lang.switch', $lang) }}" class="another_language_name"> {{$language}}</a>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
