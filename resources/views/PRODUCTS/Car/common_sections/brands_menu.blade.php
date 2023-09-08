<nav class="brands_menu_container">
	<div class="container-md nav_scroller mb-2 overflow-hidden overflow_sm_visible">
		<ul class="row row-cols-12 flex-nowrap flex-sm-wrap justify-content-sm-center mb-1 mb-sm-0 pb-0 brands_menu_logos  ">
			@foreach ($brands as $code => $brand)
				<li class="col brands_menu_item">
					<a href="{{route('cars.index', ['ff' => $code])}}">
						<div class="i_{{mb_strtolower(str_replace(" ", '', $brand))}}"></div>
						<div @if (strlen($brand) >= 10) style="font-size: 0.925rem;" @endif >{{$brand}}</div>
					</a>
				</li>
			@endforeach
		</ul>
	</div>
</nav>