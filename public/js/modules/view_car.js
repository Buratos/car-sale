function init() {
  $(document).on("click", "#btn_add_to_compare", { func: "compare_icon" }, btnClickHandler);
  $(document).on("click", "#btn_add_to_favorites", { func: "favorite_icon" }, btnClickHandler);
}

function btnClickHandler(event) {
  event.stopImmediatePropagation();
  var thiss = $(this), carId = thiss.attr("carid");

  switch (event.data.func) {
    case "compare_icon" :
      var compareElems = [], cookie = $.cookie($myApp.productName + "_compare_elems");
      if (cookie) compareElems = JSON.parse(cookie);
      $.cookie($myApp.productName + "_compare_elems", JSON.stringify(Array.from((new Set(compareElems)).add(carId))), { expires: 15, path: '/' });
      break;
    case "favorite_icon" :
      var favoritesElems = [], cookie = $.cookie($myApp.productName + "_favorites_elems");
      if (cookie) favoritesElems = JSON.parse(cookie);
      $.cookie($myApp.productName + "_favorites_elems", JSON.stringify(Array.from((new Set(favoritesElems)).add(carId))), { expires: 15, path: '/' });
      break;
  }
}

export { init }