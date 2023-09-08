<?php
$routeHome = route("cars.index");
?>
<header class="container-fluid m-0 p-0 bg-light">
	<div class="black_rect_fullscreen d-none"></div>
	<!--	HEADER с меню ДЛЯ МОБИЛКИ -->
	<div class="d-sm-none container-fluid bg-light px-0">
		<nav class="navbar navbar-expand-md navbar-light bg-light mb-0 pb-0 mobile_navbar">
			<div class="container-fluid px-0 logo_block_mobile">
				<div class="w-100 d-flex justify-content-between flex-nowrap">
					<a href="{{$routeHome}}" class="d-flex align-items-center mb-1 bg-light car_sale_logo">
						<div class="i_header_logo">
							<div><!-- ЭТОТ div тут нужен --></div>
						</div>
						<span class="text-danger fw-bold m-0">CAR SALE</span>
					</a>
					<button class="navbar-toggler collapsed mt-1 mb-1 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_mobile_red_menu" aria-controls="navbar_mobile_red_menu" aria-expanded="false" aria-label="Переключить навигацию">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
				<div class="col-12 pb-0 pb-sm-3">
					<form class="d-flex">
						<div class="input-group search_wrapper">
							<input id="search_mobile" name="search_mobile" type="search" class="form-control" placeholder="{{__("Search in ads...")}}" aria-label="Search" autocomplete="off" value="{{request()->search_mobile}}">
							<button class="btn btn-outline-secondary do_search" type="button" id="button-addon1">
								<svg width="16" height="16">
									<use xlink:href="#i_search"></use>
								</svg>
							</button>
							<div class="dynamic_search_results_mobile mt-2 mb-2 d-none"></div>
						</div>
					</form>
				</div>
				{{--				<div id="tttt" style="width: 100%;height: 1px;background-color: #AAAAAA;"></div>--}}
			</div>
			<div class="navbar-collapse collapse" id="navbar_mobile_red_menu">
				<div class="row mx-0 justify-content-center">
					@guest
						<div class="col-12 text-center mt-3 mb-3 for_unknown_user">
							<a href="{{--route('login')--}}" type="button" class="btn btn btn-outline-secondary me-2">{{ __('Login') }}</a>
							<a href="{{--route('register')--}}" type="button" class="btn btn-outline-secondary">{{ __('Register') }}</a>
						</div>
					@else
						<div class="col-12 mt-0 mb-3 px-0 d-flex flex-nowrap justify-content-center align-items-center for_logged_user">
							{{--								<a type="button" class="btn d-inline-flex align-items-center text-secondary ps-0 py-0" data-func="">
																<!-- * -->
																<svg  width="16" height="16">
																	<use xlink:href="#i_logget_user"></use>
																</svg>
																<span>{{ Auth::user()->name }}</span>
															</a>
															<button type="button" class="btn btn-outline-secondary">Log out</button>--}}
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }}
								</a>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								</div>
							</li>
						</div>
					@endguest
					<div class="col-12 bg-danger px-0">
						<ul class="navbar-nav me-auto main_menu_red">
							<li class="nav-item">
								<a href="{{route("cars.create")}}" class="nav-link active" aria-current="page">{{__("CREATE ADS")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('cars.latest')}}">{{__("LATEST ADS")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("cars.compare")}}">{{__("COMPARE")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("cars.favorites")}}">{{__("FAVORITES")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("categories")}}">{{__("CATEGORIES")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">{{__("CONTACTS")}}</a>
							</li>
							<hr class="my-1 d-sm-none text-white">
							<li class="nav-item d-sm-none">
								<a class="nav-link" href="{{ route('admin.cars.index') }}">{{__("ADMIN")}}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<!--	HEADER линия c логотипом для экранов БОЛЬШЕ мобилки -->
	<div class="container-fluid logo_block">
		<div class="d-none d-sm-block container-md bg-light ">
			<div class="d-flex flex-wrap justify-content-left align-items-center flex-nowrap">
				<a href="{{$routeHome}}" class="d-flex align-items-center mb-sm-0 mt-sd-0 bg-light me-3 car_sale_logo">
					<div class="i_header_logo">
						<div><!-- ЭТОТ div тут нужен --></div>
					</div>
					<span class="text-danger fw-bold m-0" {{--style="font-size: 2rem;"--}}>CAR SALE</span>
				</a>
				<form id="search_form" class="me-3" style="flex: 1 0 8rem" action="/search">
					<div class="input-group search_wrapper">
						<input id="search" name="search_str" type="search" class="form-control" placeholder="{{__("Search in ads...")}}" aria-label="Search" autocomplete="off" value="{{request()->search_str}}">
						<button class="btn btn-outline-secondary" id="btn_search_submit" type="submit">
							<svg width="16" height="16">
								<use xlink:href="#i_search"></use>
							</svg>
						</button>
						{{--					<input id="btn_search_submit" class="btn btn-outline-secondary" type="submit" value="SEARCH">--}}
						<div class="dynamic_search_results mt-2 mb-2 d-none "></div>
					</div>
				</form>
				<!-- Authentication Links -->
				@guest
					<div class="for_unknown_user">
						<a href="/*route('login')*/" type="button" class="btn btn btn-outline-secondary me-2">{{ __('Login') }}</a>
						<a href="{{--route('register')--}}" type="button" class="btn btn-outline-secondary">{{ __('Register') }}</a>
					</div>
				@else
					<div class="text-center for_logged_user">
						<a type="button" class="btn d-flex align-items-center text-secondary" data-func="">
							<!-- * -->
							<svg width="16" height="16">
								<use xlink:href="#i_logget_user"></use>
							</svg>
							<span>{{ Auth::user()->name }}</span>
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST">
							@csrf
							<input href="{{ route('logout') }}" type="submit" class="btn btn-outline-secondary btn-sm lh-sm mb-sm-2 mb-md-1" value="{{ __('Logout') }}">
						</form>
						{{--<a href="{{ route('logout') }}" type="button" class="btn btn-outline-secondary btn-sm lh-sm mb-sm-2 mb-md-1">{{ __('Logout') }}</a>--}}
					</div>
					
					{{--<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	
						</a>
						<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
																											 document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>--}}
				@endguest
			</div>
		</div>
	</div>
	</div>
	<!--	КРАСНОЕ МЕНЮ для экранов БОЛЬШЕ мобилки -->
	<nav class="d-none d-sm-block py-2 bg-danger text-white main_menu_red">
		<div class="container-fluid d-flex  flex-wrap">
			<ul class="nav mx-auto justify-content-center">
				<li class="nav-item">
					<a href="{{route("cars.create")}}" class="nav-link link-light px-2" aria-current="page">{{__("CREATE ADS")}}</a>
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
					<a class="nav-link link-light px-2" href="{{ route('admin.cars.index') }}">{{__("ADMIN")}}</a>
				</li>
			</ul>
		</div>
	</nav>
</header>