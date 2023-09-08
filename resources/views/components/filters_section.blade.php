{{--	           FILTERS SECTION        --}}
<script type="text/javascript">
	<?php
	if ($isAnyFiltersSelected) echo '$myApp.isAnyFiltersSelected = true;';
	else echo '$myApp.isAnyFiltersSelected = false;';
	?>
  function pluralProducts(number) {
    var rus = <?php echo app()->getLocale() == "ru" ? "true" : "false" ?>;
    if (rus && number > 20) number %= 10;
    switch (number) {
      case 1 :
        return "{{$pluralWords[0]}}";
      case 2 :
      case 3 :
      case 4 :
        return "{{$pluralWords[1]}}";
      default:
        return "{{$pluralWords[2]}}";
    }
  }
</script>
<nav class="btn_filters_container">
	<div class="container">
		<div class="row justify-content-between mt-3 mt-sm-4">
			<div class="col-6 col-sm-5 col-md-4 mb-sm-2 pe-1">
				<a id="show_filters" class="w-100 btn btn-outline-secondary lh-sm filters_closed no_filters_selected mb-2 mb-sm-1" data-func="show_filters">
					<span closed>{{__("Show filters")}}</span><span showed>{{__("Close filters")}}</span><span selected_filters_cnt></span>
				</a>
			</div>
			<div class="col-6 col-sm-5 col-md-4 mb-sm-2 ps-2">
				<a id="create_new_ad_btn" href="{{route("cars.create")}}" class="w-100 btn btn-outline-secondary lh-sm mb-2 mb-sm-1" type="button">{{__("Create new ad")}}</a>
			</div>
		</div>
	</div>
</nav>
<section class="container-fluid bg-light collapse" id="filters_global_container">
<div class="modal-content container-md bg-light filters_fullscreen_block " id="filters_container">
		<div class="filters_header">
			<div class="d-flex d-sm-none justify-content-between align-items-center pt-3 px-4 pb-3">
				<div class="d-flex align-items-center text-secondary">
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<button type="button" class="btn-close opacity-100 self" data-func="close_fullscreen_filters" aria-label="Закрыть"></button>
			</div>
			<div class="d-flex justify-content-between px-3 pb-3 p-sm-3 ">
				<div class="justify-content-start align-items-center text-secondary d-none d-sm-flex">
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<div class="d-flex justify-content-between w-100 w_sm_auto">
					<?php
					$class_d_none_clear_all_filters = $isAnyFiltersSelected ? "" : " d-none ";
					?>
					<button type="button" class="btn btn-success btn-sm px-2 px-sm-3 ms-1 me-2 me-sm-3" data-func="apply_filters">{{__("APPLY FILTERS")}}</button>
					<button type="button" class="btn btn-danger btn-sm px-2 px-sm-3 me-1 ms-sm-3 {{$class_d_none_clear_all_filters}}" data-func="clear_all_filters">{{__("CLEAR ALL FILTERS")}}</button>
				</div>
			</div>
		</div>
		<div class="row modal-body g-0 filters_content">
			<div class="col px-0 mt-0">
				{{--	**********************************************************************	--}}
				{{--	**********************************************************************	--}}
				<form class="needs-validation" novalidate="">
					<div class="accordion" id="filters_accordion"><!-- accordion-item -->
						{{-- ······························································ --}}
						@foreach ($filters as $filterGroup)
						{{--  --}}
						<?php
						if (isset($filterGroup["belongs_to"])) $params = " dependent "; else $params = " ";

						//								если нету видимых фильтров внутри, то вообще отключить видимость у группы фильтров
						$class__accordion_item__d_none = "";
						if (isset($filterGroup["is_hidden"])) {
							$noVisibleFound = true;
							$class__accordion_item__d_none = "";
							foreach ($filterGroup["is_hidden"] as $item)
								if (!$item) {
									$noVisibleFound = false;
									break;
								}
							if ($noVisibleFound) $class__accordion_item__d_none = " d-none ";
						} ?>
						@if ($filterGroup["type"] == FILTER_RANGE)
						{{-- Diapason --}}
						<?php
						$f_type = FILTER_RANGE;
						$f_title = $filterGroup["name"];
						$f_code = $filterGroup["codes"][0];
						$params .= " f_type='$f_type' f_title='$f_title' code='$f_code'";
						$totalMin = $filterGroup["totalMin"];
						$totalMax = $filterGroup["totalMax"];
						$min = ($filterGroup["values"][0] <= $totalMin) ? $totalMin : $filterGroup["values"][0];
						$max = ($filterGroup["values"][1] >= $totalMax) ? $totalMax : $filterGroup["values"][1];
						$btnClearFilters__class_d_none = ($totalMin == $min && $totalMax == $max) ? "d-none" : "";
						$checkedFilterCount = 1;
						?>
						@elseif ($filterGroup["type"] == FILTER_MINI_RANGE)
						{{-- Mini Diapason --}}
						<?php
						$f_type = FILTER_MINI_RANGE;
						$f_title = $filterGroup["name"];
						$f_code = $filterGroup["codes"][0];
						$params .= " f_type='$f_type' f_title='$f_title' code='$f_code'";
						$checkedFilterCount = array_count_values($filterGroup["checkedStatuses"])[1] ?? "";
						if ($checkedFilterCount) {
							$btnClearFilters__class_d_none = "";
						} else {
							$btnClearFilters__class_d_none = "d-none";
							$checkedFilterCount = "";
						}
						?>
						@else
						@php
						$f_type = $filterGroup["type"];
						$f_title = $filterGroup["name"];
						$params.= " f_type='$f_type' f_title='$f_title'";
						$checkedFilterCount = array_count_values($filterGroup["checkedStatuses"])[1] ?? "";
						if ($checkedFilterCount) {
						$btnClearFilters__class_d_none = "";
						} else {
						$btnClearFilters__class_d_none = "d-none";
						$checkedFilterCount = "";
						}
						@endphp
						@endif
						<div class="accordion-item {{$class__accordion_item__d_none}}" <?php echo $params ?>>
							<!-- accordion-item -->
							@php
							$collapsedClass = (in_array($loop->index,[0,1,2]))  ? "" : " collapsed ";
							$areaExpanded = ($collapsedClass)  ? "false" : "true";
							$showClass = ($collapsedClass)  ? "" : " show ";
							$collapsId = "filters_accordion_collapse_" . ($loop->index + 1);
							$collapsTitle = $filterGroup["titleOnSite"];
							$accordionHeaderId = "filters_accordion_header_" . ($loop->index+1);
							@endphp
							<h2 class="accordion-header" id="{{$accordionHeaderId}}"{{--id="filters_accordion__header1"--}}>
								<button class="accordion-button {{$collapsedClass}}" type="button" data-bs-toggle="collapse" data-bs-target="#{{$collapsId}}" aria-expanded="{{$areaExpanded}}" aria-controls="{{$collapsId}}">{{__($collapsTitle)}}
								</button>
								<a type="button" class="btn btn_clear_filters {{$btnClearFilters__class_d_none}}" data-func="clear_filters">
									<span>{{$checkedFilterCount}}</span>
									<svg width="1.15rem" height="1.15rem">
										<use xlink:href="#i_close_circle_filled" {{--width="1.15rem" height="1.15rem"--}}></use>
									</svg>
								</a>
							</h2>
							<div id="{{$collapsId}}" class="accordion-collapse collapse {{$showClass}}" aria-labelledby="{{$accordionHeaderId}}">
								<div class="accordion-body">
									@if ($filterGroup["type"] == FILTER_RANGE)
									{{--Diapason--}}
									<?php
									$class__d_none = ($filterGroup["is_hidden"][0] ?? false) ? " d-none " : "";
									$belongs_to = ($filterGroup["belongs_to"][0] ?? "") ? ' belongs_to="inputCheckbox' . $filterGroup["belongs_to"][0] . '" ' : "";
									$code = $filterGroup["codes"][0];
									?>
									<div class="filter_diapason_wrapper {{$class__d_none}}" code="{{$code}}" <?php echo $belongs_to; ?>>
										<span>{{__("From")}}</span>
										<input type="number" id="input_min_{{$code}}" name="min_{{$filterGroup["name"]}}" value="{{$min}}" {{--applied_value="{{$min}}"--}} placeholder="{{$totalMin}}">
										<span>{{__("to")}}</span>
										<input type="number" id="input_max_{{$code}}" name="max_{{$filterGroup["name"]}}" value="{{$max}}" {{--applied_value="{{$max}}"--}} placeholder="{{$totalMax}}">
										<span class="btn btn-secondary apply_diapason_filter" data-func="apply_diapason_filter">{{__("OK")}}</span>
									</div>
									<div class="range-slider">
										<input id="filter-range-slider_{{$code}}" type="text" value="">
									</div>
									@else
									<?php /* это для разделения зависимых фильтров по полосам с разными цветами, в соответствии с chief filter */
									if (isset($filterGroup["belongs_to"])) {
										$tag_ul_open = "<ul class='depended_filters_list'>";
										$tag_ul_close = "</ul>";
//													$tag_li_open = "<li>";
										$tag_li_close = "</li>";
									} else $tag_ul_open = $tag_ul_close = $tag_li_close = "";
									$prevChiefCode = "";
									echo $tag_ul_open;
									$number_of_depended_elements_string = 0;
									?>
									@foreach ($filterGroup["values"] as $index => $value)
									<?php
									// это для разделения зависимых фильтров по полосам с разными цветами, в соответствии с chief filter
									$chiefCode = $filterGroup["belongs_to"][$index] ?? "";
									if ($chiefCode && $prevChiefCode && $chiefCode != $prevChiefCode) echo $tag_li_close;
									if ($chiefCode && $chiefCode != $prevChiefCode) {
										$li_class_d_none = "d-none";
										foreach ($filters as $tmpFilterGroup) {
											$index22 = array_search($chiefCode, $tmpFilterGroup["codes"]);
											if ($index22 === false) continue;
											if ($tmpFilterGroup["checkedStatuses"][$index22]) $li_class_d_none = "";
											break;
										}
										if (!$li_class_d_none) $number_of_depended_elements_string++;
										if ($number_of_depended_elements_string % 2 == 0 && !$li_class_d_none) $li_class_d_none = " depended_even ";
										echo "<li class='$li_class_d_none' belongs_to='$chiefCode'>";
									}
									// -------------------------------------------------------------------------------------------------
									$classes__filter_color = " d-none "; $colorValue = "";
									switch ($filterGroup["type"]) {
										case FILTER_RELATIONSHIP :
											$value = $filterGroup["binded_table_values"][$index];
											break;
										case FILTER_COLOR :
											$classes__filter_color = "";
											[$value, $colorValue] = explode("--", $filterGroup["binded_table_values"][$index]);
											if ($colorValue == "#FFFFFF") $classes__filter_color = " filter_color_white "; else $classes__filter_color = "filter_color";
											break;
										case FILTER_YESNO :
											$value = ($value == 1) ? "Yes" : "No";
											break;
										default:
											break;
									}
									$code = $filterGroup["codes"][$loop->index];
									$inputCheckboxId = "input_checkbox" . $code;
									$class__d_none = "";
									$belongs_to = ($filterGroup["belongs_to"][$loop->index] ?? "") ? ' belongs_to="input_checkbox' . $filterGroup["belongs_to"][$loop->index] . '" ' : "";
									$amount = $filterGroup["amounts"][$loop->index];
									$checked = $filterGroup["checkedStatuses"][$loop->index] ? " checked" : "";
									$spanId = "f_" . $filterGroup["name"] . ($loop->index + 1);
									?>
									{{--                     filter BTN                                   --}}
									<label class="btn_checkbox btn_checkbox_filter {{$class__d_none}}" code="{{$code}}" <?php echo $belongs_to; ?>>
										<input type="checkbox" class="input_checkbox_filter" id={{$inputCheckboxId}} {{$checked}} code="{{$code}}">
										<div class="btn_checkbox_text">
											@if(!Str::contains($classes__filter_color, 'd-none'))
												<color class="{{$classes__filter_color}}" style="background-color: {{$colorValue}};"></color>
											@endif
											<span>{{__($value)}}</span><span id="span2{{$code}}">{{$amount}}</span>
										</div>
									</label>
									{{--                                                                   --}}
									<?php
									$prevChiefCode = $filterGroup["belongs_to"][$index] ?? "";
									?>
									@endforeach
									<?php
									echo $tag_ul_close;
									?>
									@endif
								</div>
							</div>
						</div>
						@endforeach
						{{-- ······························································ --}}
					</div>
				</form>
				{{--	**********************************************************************	--}}
				{{--	**********************************************************************	--}}
			</div>
		</div>
		<div class="filters_header">
			<div class="d-flex d-sm-none justify-content-between align-items-center pt-3 px-4 pb-3">
				<div class="d-flex align-items-center text-secondary">
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<button type="button" class="btn-close opacity-100 self" data-func="close_fullscreen_filters" aria-label="Закрыть"></button>
			</div>
			<div class="d-flex justify-content-between px-3 pb-3 p-sm-3 ">
				<div class="justify-content-start align-items-center text-secondary d-none d-sm-flex">
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<div class="d-flex justify-content-between w-100 w_sm_auto">
					<button type="button" class="btn btn-success btn-sm px-2 px-sm-3 ms-1 me-2 me-sm-3" data-func="apply_filters">{{__("APPLY FILTERS")}}</button>
					<button type="button" class="btn btn-danger btn-sm px-2 px-sm-3 me-1 ms-sm-3 {{$class_d_none_clear_all_filters}}" data-func="clear_all_filters">{{__("CLEAR ALL FILTERS")}}</button>
				</div>
			</div>
		</div>
	</div>
</section>
{{--	        FILTERS SECTION END	           --}}