@props(["name","title"])
<div class="form-group">
	<label for="{{$name}}">{{$title}}</label>
	<input class="form-control" id="{{$name}}" name="{{$name}}" {{$attributes}}>
</div>
				