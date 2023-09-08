function init() {
  // load results for dynamic search
  // $(document).on("change", "#search, #search_mobile", { dynamic: true }, searchHandler);
  // $(document).on("keyup", "#search, #search_mobile", { dynamic: true }, searchHandler);
  $(document).on("input", "#search, #search_mobile", { dynamic: true }, searchHandler);
  $(document).on("focus", "#search, #search_mobile", { focus: true }, searchFocusHandler);
  $(document).on("blur", "#search, #search_mobile", { focus: false }, searchFocusHandler);
  // Enter-key pressed in the search input
  $(document).on("submit ", "#search_form"/*"#search, #search_mobile"*/, { dynamic: false }, searchHandler);
  // click on search-btn
  $(document).on("click", "#btn_search_submit", { dynamic: false }, searchHandler);
}

function searchHandler(event) {
  if (typeof (searchHandler.savedSearchPhrase) == "undefined") searchHandler.savedSearchPhrase = "";

  if (isMobileViewport()) {
    var divTitle = ".dynamic_search_results_mobile",
      inputTitle = "#search_mobile";
  } else {
    var divTitle = ".dynamic_search_results",
      inputTitle = "#search";
  }
  var dynamicSearchResults = $(divTitle),
    searchStr = $(inputTitle).val();
  searchStr.trim();
  if (searchStr.length < 3) {
    searchHandler.savedSearchPhrase = searchStr;
    dynamicSearchResults.addClass("d-none");
    return;
  }

  var words = searchStr.split(" ");
  words = words.filter(function (item, index) {
    return item.length >= 2;
  });
  if (words.length == 0) return;
  searchStr = words.slice(0, 2).join(" ");

  var requestType, requestUrl;
  if (event.data.dynamic) {
    event.preventDefault();  // disable other event handlers
    if (searchStr == searchHandler.savedSearchPhrase) return;
    searchHandler.savedSearchPhrase = searchStr;
    requestType = "POST";
    requestUrl = "/search";
  } else {
    requestType = "GET";
    requestUrl = "/search";
    return
  }

  $.ajax({
    url     : requestUrl,
    type    : requestType,
    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    data    : { search_str: searchStr },
    dataType: 'json'
  }).done(function (responseData, b, c) {                   // SUCCESS
    if (!responseData.success) {
      dynamicSearchResults.addClass("d-none");
      return;
    }
    dynamicSearchResults.removeClass("d-none");
    dynamicSearchResults.html(responseData.html)
    var handle = function (event) {
      dynamicSearchResults.addClass("d-none");
      $(document).off("click", "*", handle);
    }
    $(document).on("click", "*", handle);
  }).fail(function (jqXHR, status, errorThrown) {            // ERROR
    console.log('DYNAMIC_SEARCH > ОШИБКА AJAX запроса: ' + status, jqXHR);
  });
}


function searchFocusHandler(event) {
  if (event.data.focus) {
    $(".black_rect_fullscreen").removeClass("d-none");
  } else {
    $(".black_rect_fullscreen").addClass("d-none");
  }

}

export { init }