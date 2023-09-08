function init() {
  init_sortMode_perPage_URL();
  // ▪▪▪▪▪▪▪▪ EVENTS
  $(document).on("change", "#sort_mode", {}, sortModeClickHandler);
  $(document).on("change", "#elems_per_page", {}, elemsPerPageClickHandler);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪ functions ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

/*
 инициализирует механизм для сортировки и perpage
 */
function init_sortMode_perPage_URL() {
  $myApp.sortModes[$myApp.productName] = $("#sort_mode").val();
  if ($myApp.sortModes[$myApp.productName] == "random") {
    var cookie = $.cookie($myApp.productName + '_sort_mode');
    if (cookie) {
      $myApp.sortModes[$myApp.productName] = cookie;
      $("#sort_mode").val(cookie)
    }
  }
  // addParamInURL("sort", $myApp.sortMode);

  $myApp.perPages[$myApp.productName] = +$("#elems_per_page").val();
  if ($myApp.perPages[$myApp.productName] == "random") {
    var cookie = $.cookie($myApp.productName + '_per_page');
    if (cookie) {
      $myApp.perPages[$myApp.productName] = cookie;
      $("#elems_per_page").val(cookie)
    }
  }
  // addParamInURL("perpage", $myApp.perPage);
}

function sortModeClickHandler(event) {
  $myApp.sortModes[$myApp.productName] = $(this).val();
  $.cookie($myApp.productName + '_sort_mode', $myApp.sortModes[$myApp.productName], { expires: 15, path: '/' });
  var currentURL = new URL(window.location);
  // currentURL.searchParams.set("sort", $myApp.sortMode);
  // currentURL.searchParams.set("perpage", $myApp.perPage);
  window.location.href = currentURL.href;
}

function elemsPerPageClickHandler(event) {
  $myApp.perPages[$myApp.productName] = $(this).val();
  $.cookie($myApp.productName + '_per_page', $myApp.perPages[$myApp.productName], { expires: 15, path: '/' });
  var currentURL = new URL(window.location);
  if (window.location.href.indexOf('page=') !== -1) {
    currentURL.searchParams.set("page", 1);
  }
  // currentURL.searchParams.set("sort", $myApp.sortMode);
  // currentURL.searchParams.set("perpage", $myApp.perPage);
  window.location.href = currentURL.href;
}

export { init }