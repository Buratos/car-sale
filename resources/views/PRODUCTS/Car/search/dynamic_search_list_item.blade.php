<ul>
	@foreach($foundCars as $item)
		<li class="dynamic_search_list_item">
			<a href="{{route('car.view',[$item['id']])}}">{{$item["title"]}}</a>
		</li>
	@endforeach
	@if ($numberAdditionallyFound > 0)
		<li class="dynamic_search_list_item ">
			<a class="additional_message_below" href="{{route("cars.search", ["search_str" => $searchStr])}}">{{__("click here for more results...")}}</a>
		</li>
	@endif
</ul>
