function init() {
  $(document).on("click", ".input_compare", { func: "compare_icon" }, productCardIcons_ClickHandler);
  $(document).on("click", ".input_favorite", { func: "favorite_icon" }, productCardIcons_ClickHandler);
}

function productCardIcons_ClickHandler(event) {
  event.stopImmediatePropagation();
  var thiss = $(this), isChecked = thiss.prop("checked"), carId = thiss.attr("carid");
  const COMPARE_ELEMS = $myApp.productName + "_compare_elems";
  const FAVORITES_ELEMS = $myApp.productName + "_favorites_elems";
  var productCard = $("#" + $myApp.productCardClassName + thiss.attr("carid"));

  // нажата иконка ИМЕННО на extended_????_card
  switch (event.data.func) {
    case "compare_icon" :
      var compareElems = [], cookie = $.cookie(COMPARE_ELEMS);
      if (cookie) compareElems = JSON.parse(cookie);
      if (isChecked) {
        $.cookie(COMPARE_ELEMS, JSON.stringify(Array.from((new Set(compareElems)).add(carId))), { expires: 15, path: '/' });
        productCard.find(".input_compare").prop("checked", true)
      } else {
        compareElems = new Set(compareElems);
        compareElems.delete(carId);
        $.cookie(COMPARE_ELEMS, JSON.stringify(Array.from(compareElems)), { expires: 15, path: '/' });
        productCard.find(".input_compare").prop("checked", false)

      }
      break;
    case "favorite_icon" :
      var favoritesElems = [], cookie = $.cookie(FAVORITES_ELEMS);
      if (cookie) favoritesElems = JSON.parse(cookie);
      if (isChecked) {
        $.cookie(FAVORITES_ELEMS, JSON.stringify(Array.from((new Set(favoritesElems)).add(carId))), { expires: 15, path: '/' });
        productCard.find(".input_favorite").prop("checked", true)
      } else {
        favoritesElems = new Set(favoritesElems);
        favoritesElems.delete(carId);
        $.cookie(FAVORITES_ELEMS, JSON.stringify(Array.from(favoritesElems)), { expires: 15, path: '/' });
        productCard.find(".input_favorite").prop("checked", false)

      }
      break;
  }
}

export { init }