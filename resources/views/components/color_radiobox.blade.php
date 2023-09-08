@props(["name", "classes"=>"", "checked"=>"", "color"])
<label class="btn_checkbox btn_color_radio {{$classes}}">
	<?php
	$classes_color = "";
	[$colorName, $colorValue] = explode("--", $color);
	if ($colorValue == "#FFFFFF") $classes_color = " filter_color_white "; else $classes_color = "filter_color";
	?>
	<input type="radio" class="color_radio" name="{{$name}}" {{$checked}} value="{{$color}}">
	<div class="btn_checkbox_text">
		<color class="{{$classes_color}}" style="background-color: {{$colorValue}};"></color>
		<span>{{__($colorName)}}</span>
	</div>
</label>
