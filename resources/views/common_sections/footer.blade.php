{{-- ······························································ --}}

<!--▪▪▪▪▪▪▪▪▪▪▪▪▪  FOOTER   ПОДВАЛ  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪-->
<footer>
	<nav class=" py-0  border-bottom text-white main_menu_footer">
		<div class="container-fluid d-flex flex-wrap">
			<ul class="nav mx-auto justify-content-center">
				<li class="nav-item">
					<a href="{{route("cars.create")}}" class="nav-link link-light px-2 active" aria-current="page">{{__("CREATE ADS")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route('cars.latest')}}" class="nav-link link-light px-2">{{__("LATEST ADS")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("cars.compare")}}" class="nav-link link-light px-2">{{__("COMPARE")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("cars.favorites")}}" class="nav-link link-light px-2">{{__("FAVORITES")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("categories")}}" class="nav-link link-light px-2">{{__("CATEGORIES")}}</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link link-light px-2">{{__("CONTACTS")}}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link link-light px-2" href="#">{{__("ADMIN")}}</a>
				</li>
			</ul>
		</div>
	</nav>
</footer>
