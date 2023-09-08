function init() {
  if ($myApp.isAnyFiltersSelected) filterClickHandler("REQUEST FILTER NUMBERS WHEN PAGE IS LOADED");

  handleBtnShowFilters("init");
  $(document).on("click", "[data-func=show_filters]", { btn_function: "show_filters" }, filterClickHandler);
  $(document).on("click", "[data-func=close_fullscreen_filters]", { btn_function: "close_fullscreen_filters" }, filterClickHandler);
  $(document).on("click", "[data-func=apply_diapason_filter]", { btn_function: "diapason_filter_clicked" }, filterClickHandler);
  $(document).on("click", "[data-func=clear_all_filters]", { btn_function: "clear_all_filters" }, filterClickHandler);
  $(document).on("click", "[data-func=apply_filters]", { btn_function: "apply_filters" }, filterClickHandler);
  $(document).on("click", ".input_checkbox_filter", { btn_function: "one_simple_filter_clicked" }, filterClickHandler);
  $(document).on("mouseup", ".btn_clear_filters", { btn_function: "clear_one_group_of_filters" }, filterClickHandler);
  //  init слайдер для диапазонных фильтров с двумя инпутами
  initRangeSliders();
  // открыть фильтры ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // open_filters_for_debug();
}

/* ♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦ */
function open_filters_for_debug() {
  var elem = $('#filters_global_container');
  elem.collapse("toggle")
  // распахнуть фильтры на мобилке
  if (isMobileViewport()) {
    $("body").css("pointer-events", "none");
    elem.addClass("h-100");
  }
  handleBtnShowFilters();
}

/* ♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦ FUNCTIONS ♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦ */

function filterClickHandler(event) {
  var URL = $myApp.calculateFiltersUrl;
  if (event != "REQUEST FILTER NUMBERS WHEN PAGE IS LOADED") {
    event.stopImmediatePropagation();
    var thiss = $(this);
    switch (event.data.btn_function) {
      case "clear_one_group_of_filters":                      // -----------------------
        clearOneGroupOfFilters(thiss);
        break;
      case "clear_all_filters":                               // -----------------------
        clearAllFilters();
        break;
      case "one_simple_filter_clicked":                       // -----------------------
        oneSimpleFilterClicked();
        break;
      case "diapason_filter_clicked":                         // -----------------------
        diapasonFilterClicked(thiss);
        break;
      case "show_filters":                                     // -----------------------
        showFiltersClicked();
        return;
      case "close_fullscreen_filters":                         // -----------------------
        event.stopImmediatePropagation();
        $('#filters_global_container').removeClass("h-100");
        $('#filters_global_container').collapse("toggle");
        $("body").css("pointer-events", "auto");
        // handleBtnShowFilters();
        return;
      case "apply_filters" :                                   // -----------------------
        var URL = "";
        break;
    }
  }
  // надо включить или выключить кнопки clear_all_filters и apply_filters
  var isCheckedFiltersExist = ($(".btn_clear_filters").map(function (index, item) {
    if ($(item).hasClass("d-none")) return null;
    else return 1;
  }).length > 0);
  if (isCheckedFiltersExist) $("[data-func=clear_all_filters]").removeClass("d-none");
  else $("[data-func=clear_all_filters]").addClass("d-none");

  // подготовить набор фильтров для отправки на сервер
  var checkedFilters = $("input.input_checkbox_filter:checked").map((index, elem) => $(elem).attr("code")).toArray();
  var diapasonFilters = $(".accordion-item[f_type=D]").map(function (index, elem) {
    elem = $(elem);
    // var title = elem.attr("f_title");
    var code = elem.attr("code");
    var min = +elem.find("#input_min_" + code).val();
    var max = +elem.find("#input_max_" + code).val();
    var totalMin = +elem.find("#input_min_" + code).attr("placeholder");
    var totalMax = +elem.find("#input_max_" + code).attr("placeholder");

    // проверить и откорректировать значения min max
    if (min > max) {
      let t = min;
      min = max;
      max = min;
    }
    if (min < totalMin) min = totalMin;
    if (max > totalMax) max = totalMax;
    if (min == totalMax) {
      min = totalMin;
      max = totalMax;
    }
    if (min <= totalMin && max >= totalMax) return null; // вычеркиваем этот D из набора, тут значения равны totalM__
    else return [[code, min, max]];
  }).toArray();

  if (URL == $myApp.calculateFiltersUrl) var successFunc = successFunc_calculate_filters;
  else {
    $myApp.checkedFilters = checkedFilters;
    $myApp.diapasonFilters = diapasonFilters;
    window.location.href = generateURL();
    return;
  }
  handleBtnShowFilters("no toggle");

  // отправка данных на сервер и обработка ответа
  $.ajax({
    url     : URL,
    type    : 'POST',
    dataType: 'json',
    headers : {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data    : {
      checkedFilters : checkedFilters,
      diapasonFilters: diapasonFilters,
      sort           : $myApp.sortMode,
      perpage        : $myApp.perPage,
      methodPOST     : 1
    },
    success : successFunc,                                        // SUCCESS ----------------
    error   : function (jqXHR, status, errorThrown) {             // ERROR ----------------
      console.log('filter_click_handler > ОШИБКА AJAX запроса: ' + status, jqXHR);
    }
  });

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ вспомогательные функции ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  function successFunc_calculate_filters(response_data, b, c) {
    var length = response_data.filters.length;
    for (let i = 0; i < length; i++) {
      var oneFilter = response_data.filters[i];
      var code = oneFilter[0];
      if (oneFilter.length == 3) {        //     Diapason filter
        var min = oneFilter[1], max = oneFilter[2];
        $("#input_min_" + code).val(min);
        $("#input_max_" + code).val(max);
      } else                              //    Normal or Relationship filter
        $("#span2" + code).text(oneFilter[1]);
    }
    $(".total_products_found").text(response_data.selectedItemsTotalCount);

    $("plural_products").text(pluralProducts(response_data.selectedItemsTotalCount));
    // надо модифицировать строку URL у браузера

    /*
     var URLparameters = "";
     if (checkedFilters.length || diapasonFilters.length) {
     var URLparameters = "?";
     for (let i = 0; i < checkedFilters.length; i++) {
     if (i == 0) URLparameters += "ff=";
     URLparameters += checkedFilters[i];
     if (i < (checkedFilters.length - 1)) URLparameters += "-";
     }
     if (checkedFilters.length && diapasonFilters.length) URLparameters += "&";
     for (let i = 0; i < diapasonFilters.length; i++) {
     if (i == 0) URLparameters += "fd=";
     URLparameters += diapasonFilters[i][0] + "_" + diapasonFilters[i][1] + "_" + diapasonFilters[i][2];
     if (i < (diapasonFilters.length - 1)) URLparameters += "-";
     }
     }
     // если в URL есть page=*, добавляю его в строку, чтобы не удалялось
     const urlParams = new URLSearchParams(window.location.search);
     const currentPage = parseInt(urlParams.get('page'));
     if (currentPage > 0) URLparameters += "&page=" + currentPage;
     updateFiltersInURL(URLparameters);
     */

    // const urlParams = new URLSearchParams(window.location.search);
    // var url = new URL(window.location.href);

    var urlParams = new URLSearchParams(window.location.search);
    var ff_parameter = "";
    if (checkedFilters.length) {
      for (let i = 0; i < checkedFilters.length; i++) {
        ff_parameter += checkedFilters[i];
        if (i < (checkedFilters.length - 1)) ff_parameter += "-";
      }
    }
    // urlParams.set("ff", ff_parameter);
    if (ff_parameter) urlParams.set("ff", ff_parameter);
    else urlParams.delete("ff");

    var fd_parameter = "";
    if (diapasonFilters.length) {
      for (let i = 0; i < diapasonFilters.length; i++) {
        fd_parameter += diapasonFilters[i][0] + "_" + diapasonFilters[i][1] + "_" + diapasonFilters[i][2];
        if (i < (diapasonFilters.length - 1)) fd_parameter += "-";
      }
    }
    if (fd_parameter) urlParams.set("fd", fd_parameter);
    else urlParams.delete("fd");

    changeCurrentUrl(window.location.origin + window.location.pathname + "?" + urlParams.toString());

  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
} // конец  filter_click_handler

function handleBtnShowFilters(noToggle = "") {
  if (!isMobileViewport() && !noToggle) $("#show_filters").toggleClass("filters_closed");
  // if (!$("#show_filters").hasClass("filters_closed")) return;
  var selectedFilterNumbersByGroups = $(".btn_clear_filters:not(.d-none)");
  var selectedFilterCnt = 0;
  for (let i = 0; i < selectedFilterNumbersByGroups.length; i++) {
    var number = +selectedFilterNumbersByGroups.eq(i).find("span:first-of-type").text();
    selectedFilterCnt += number;
  }
  if (selectedFilterCnt) {
    $("#show_filters").removeClass("no_filters_selected").find("span[selected_filters_cnt]").text(selectedFilterCnt);
  } else $("#show_filters").addClass("no_filters_selected");

}


//  обработка всего, что надо внутри панели с зависимыми фильтрами, а если надо, то и отключение этой панели
function handleDependentFilters() {
  $(".accordion-item[dependent]").each(function (index, elem) {
    elem = $(elem);
    var dependedStringsOfFilters = elem.find("ul.depended_filters_list > li[belongs_to]").filter(function (index, elem) {
      elem = $(elem);
      var chiefFilterCode = elem.attr("belongs_to");
      if ($("#input_checkbox" + chiefFilterCode).prop("checked")) {
        elem.removeClass("d-none");
        return true;
      } else {
        elem.addClass("d-none");
        elem.find("input").each(function () {
          $(this).prop("checked", false);
        })
        return false;
      }
    });
    dependedStringsOfFilters.each(function (index, elem) {
      elem = $(elem);
      if (index % 2) elem.addClass("depended_even");
      else elem.removeClass("depended_even");
    });
    if (dependedStringsOfFilters.length) elem.removeClass("d-none");
    else elem.addClass("d-none")
  });
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function updateFiltersInURL(additionalStr) {
  if (history.pushState) {
    var baseUrl = window.location.origin;
    var newUrl = baseUrl + additionalStr;
    newUrl = new URL(newUrl);

    // newUrl.searchParams.set("sort", $myApp.sortMode);
    // newUrl.searchParams.set("perpage", $myApp.perPage);
    history.pushState(null, null, newUrl.href);
  } else {
    console.warn('History API is not supported by your browser');
  }
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function changeCurrentUrl(url) {
  if (history.pushState) {
    // newUrl.searchParams.set("sort", $myApp.sortMode);
    // newUrl.searchParams.set("perpage", $myApp.perPage);
    history.pushState(null, null, url);
  } else {
    console.warn('History API is not supported by your browser');
  }
}

function clearOneGroupOfFilters(thiss) {
  var accordionItem = find_parent(thiss, "accordion-item");
  if (accordionItem.attr("f_type") == "D") {
    var code = accordionItem.attr("code");
    var inputMin = accordionItem.find("#input_min_" + code);
    var inputMax = accordionItem.find("#input_max_" + code);
    inputMin.val(inputMin.attr("placeholder")).trigger("input");
    inputMax.val(inputMax.attr("placeholder")).trigger("input");
  } else {
    accordionItem.find(".input_checkbox_filter").prop("checked", false);
  }
  thiss.addClass("d-none");
  handleDependentFilters();
}

function clearAllFilters() {
  $(".btn_clear_filters").addClass("d-none");
  $(".accordion-item").find("input.input_checkbox_filter:checked").prop("checked", false);
  $(".accordion-item[f_type=D]").each(function (index, elem) {
    var accordionItem = $(elem);
    var code = accordionItem.attr("code");
    var inputMin = accordionItem.find("#input_min_" + code);
    var inputMax = accordionItem.find("#input_max_" + code);
    inputMin.val(inputMin.attr("placeholder"));
    inputMax.val(inputMax.attr("placeholder"));
  });
  // $("[data-func=apply_filters]").removeClass("d-none")
  handleDependentFilters();
}

function oneSimpleFilterClicked() {
  var accordionItems = $(".accordion-item");
  handleDependentFilters();
  for (let i = 0; i < accordionItems.length; i++) {
    // включаю круглую красную кнопку Х с цифрой btn где надо
    var accordionItem = accordionItems.eq(i);
    if (!accordionItem.find("input.input_checkbox_filter").length) continue;
    var checkeds = accordionItem.find("input.input_checkbox_filter:checked");
    var btn_clear_filters = accordionItem.find(".btn_clear_filters");
    if (checkeds.length) {          // в этой группе есть выбранные фильтры, включить кнопку X
      btn_clear_filters.find("span").text(checkeds.length);
      btn_clear_filters.removeClass("d-none");
    } else btn_clear_filters.addClass("d-none");  // сделать кнопу Х невидимой
  }
}

function diapasonFilterClicked(thiss) {
  var accordionItems = $(".accordion-item[f_type=D]");
  for (let i = 0; i < accordionItems.length; i++) {
    // включаю Х btn где надо
    var accordionItem = find_parent(thiss, "accordion-item");
    var btn_clear_filters = accordionItem.find(".btn_clear_filters");
    var code = accordionItem.attr("code");
    var min = +accordionItem.find("#input_min_" + code).val();
    var max = +accordionItem.find("#input_max_" + code).val();
    var totalMin = +accordionItem.find("#input_min_" + code).attr("placeholder");
    var totalMax = +accordionItem.find("#input_max_" + code).attr("placeholder");

    if (min < totalMin) accordionItem.find("#input_min_" + code).val(totalMin);
    if (max > totalMax) accordionItem.find("#input_max_" + code).val(totalMax);
    if (min <= totalMin && max >= totalMax) btn_clear_filters.addClass("d-none");
    else {
      btn_clear_filters.find("span").text(1);
      btn_clear_filters.removeClass("d-none");
    }
  }
}

function showFiltersClicked() {
  handleBtnShowFilters();
  var elem = $('#filters_global_container');
  elem.collapse("toggle");
  if (isMobileViewport() && $("#filters_global_container ").hasClass("show")) {
    // закрыть фильтры на мобилке
    $("body").css("pointer-events", "auto");
    elem.removeClass("h-100");
  } else if (isMobileViewport()) {
    // распахнуть фильтры на мобилке
    $("body").css("pointer-events", "none");
    elem.addClass("h-100");
  }
}

// инициализация полосок слайдеров с двумя ползунками min и max
function initRangeSliders() {
  var wrappers = $(".filter_diapason_wrapper");
  for (let i = 0; i < wrappers.length; i++) {
    var code = wrappers.eq(i).attr("code");

    var range = $("#filter-range-slider_" + code),
      inputMin = wrappers.eq(i).find("#input_min_" + code),
      inputMax = wrappers.eq(i).find("#input_max_" + code),
      instance,
      totalMin = inputMin.attr("placeholder"),
      totalMax = inputMax.attr("placeholder"),
      from = inputMin.val(),
      to = inputMax.val();

    range.ionRangeSlider({
      skin    : ["flat", "modern", "round"][i % 3],
      type    : "double",
      min     : totalMin,
      max     : totalMax,
      from    : from,
      to      : to,
      inputMin: inputMin,
      inputMax: inputMax,
      onStart : updateInputs,
      onChange: updateInputs,
    });
    instance = range.data("ionRangeSlider");

    inputMin.on("input", instance, function (event) {
      var thiss = $(this),
        val = +thiss.prop("value"),
        min = +thiss.attr("placeholder");
      // validate
      if (val < min) val = min;
      else if (val > to) val = to;

      event.data.update({
        from: val
      });
    });

    inputMax.on("input", instance, function (event) {
      var thiss = $(this),
        val = +thiss.prop("value"),
        max = +thiss.attr("placeholder");

      // validate
      if (val < from) val = from;
      else if (val > max) val = max;

      event.data.update({
        to: val
      });
    });

    function updateInputs(data) {
      from = data.from;
      to = data.to;
      this.inputMin.prop("value", from);
      this.inputMax.prop("value", to);
    }
  }
}

function generateURL() {
  var URLparameters = "";
  if ($myApp.checkedFilters.length || $myApp.diapasonFilters.length) {
    var URLparameters = "?";
    for (let i = 0; i < $myApp.checkedFilters.length; i++) {
      if (i == 0) URLparameters += "ff=";
      URLparameters += $myApp.checkedFilters[i];
      if (i < ($myApp.checkedFilters.length - 1)) URLparameters += "-";
    }
    if ($myApp.checkedFilters.length && $myApp.diapasonFilters.length) URLparameters += "&";
    for (let i = 0; i < $myApp.diapasonFilters.length; i++) {
      if (i == 0) URLparameters += "fd=";
      URLparameters += $myApp.diapasonFilters[i][0] + "_" + $myApp.diapasonFilters[i][1] + "_" + $myApp.diapasonFilters[i][2];
      if (i < ($myApp.diapasonFilters.length - 1)) URLparameters += "-";
    }
  }
  var newUrl = new URL(window.location.origin + window.location.pathname + URLparameters);
  if ($myApp.sortMode) newUrl.searchParams.set("sort", $myApp.sortMode);
  if ($myApp.perPage) newUrl.searchParams.set("perpage", $myApp.perPage);
  return newUrl.href;
}

export { init }