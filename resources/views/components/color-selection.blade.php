<div class="form-group x_color_selection" style="margin-bottom: 0.55rem">
	<div class="x_color_selection_title">
		<label id="select_color_title">{{__("Select color of a car")}}</label>
		<hr class="mt-0 mb-2" style="border-color:#5d5d5d;">
	</div>
	@foreach($colors as $color)
		<x-color_radiobox name="car_color" color="{{$color}}" checked='{{$color == $value ? "checked" : ""}}'/>
	@endforeach
</div>