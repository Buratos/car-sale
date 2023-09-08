function init() {
  $(document).on("click", ".input_compare", { func: "compare_icon" }, favoritesClickHandler);
  $(document).on("click", ".input_favorite", { func: "favorite_icon" }, favoritesClickHandler);
  $(document).on("click", "#clear_favorites", { func: "clear_favorites" }, favoritesClickHandler);
}

function favoritesClickHandler(event) {
  event.stopImmediatePropagation();
  var thiss = $(this);

  switch (event.data.func) {
    case "compare_icon" :
      compareIconClickHandle(thiss)
      break;
    case "favorite_icon" :
      var elementsLeft = removeOneElemFromFavorites(thiss);
      if (!elementsLeft) clearFavorites();
      break;
    case "clear_favorites":
      clearFavorites();
      break;
  }
}

function compareIconClickHandle(thiss) {
  var compareElems = [], cookie = $.cookie($myApp.productName + "_compare_elems"), isChecked = thiss.prop("checked"), carId = thiss.attr("carid");
  if (cookie) compareElems = JSON.parse(cookie);
  if (isChecked) {
    $.cookie($myApp.productName + "_compare_elems", JSON.stringify(Array.from((new Set(compareElems)).add(carId))), { expires: 15, path: '/' });
  } else {
    compareElems = new Set(compareElems);
    compareElems.delete(carId);
    $.cookie($myApp.productName + "_compare_elems", JSON.stringify(Array.from(compareElems)), { expires: 15, path: '/' });
  }
}

function removeOneElemFromFavorites(thiss) {
  var favoritesElems = [], cookie = $.cookie($myApp.productName + "_favorites_elems"), carId = thiss.attr("carid");
  favoritesElems = JSON.parse(cookie);
  favoritesElems = new Set(favoritesElems);
  favoritesElems.delete(carId);
  $.cookie($myApp.productName + "_favorites_elems", JSON.stringify(Array.from(favoritesElems)), { expires: 15, path: '/' });
  // надо удалить car_card с экрана
  var carCard = find_parent(thiss, $myApp.productCardClassName + "_container");
  carCard.animate({ width: '0px', height: "0px" }, 200, function () {
    $(this).remove();
  });
  return favoritesElems.size;
}

function clearFavorites() {
  $.cookie($myApp.productName + "_favorites_elems", JSON.stringify([]), { expires: 15, path: '/' });
  // надо удалить весь блок контента с экрана
  var content = $(".content");
  content.animate({ width: '0px', height: "0px" }, 200, function () {
      $(".no_cars_in_favorits").removeClass("d-none");
      $(this).remove();
    }
  );
}

export { init }