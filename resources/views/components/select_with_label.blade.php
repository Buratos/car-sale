<div class="form-group">
	<label for="{{$name}}">{{$title}}</label>
	<select class="form-select"{{--class="form-control"--}} id="{{$name}}" name="{{$name}}" placeholder="{{__("Select brand")}}" {{$attributes->except(["name","title","options","value"])}}>
		@foreach($options as $option)
			<option {{$option == $value ? "selected" : ""}} value="{{$option}}">{{__($option)}}</option>
		@endforeach
	</select>
</div>
