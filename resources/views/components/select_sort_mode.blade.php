<label>{{__("Sort by")}}</label>
<select id="sort_mode" class="form-select form-select-sm">
	@foreach ($sortModesAndTexts as $sortModeTitle => $sortModeText)
		<option value="{{$sortModeTitle}}" {{$sortMode == $sortModeTitle ? "selected" : ""}}>{{__($sortModeText)}}</option>
	@endforeach
</select>