// ▪▪▪▪▪ этот код ниже реализует возникновение расширенной карточки товара при наведении мышкой на car_card
function init() {
  $(document).on("mouseover", ".car_card", {}, carCardMouseover);
  $(document).on("mouseout", ".extended_car_card", {}, extCardMouseout);
  $(document).on("mousemove", ".extended_car_card", {}, extCardMouseout);
  $(document).on("mouseover", ".ext_car_card_microphoto", {}, extendedCarCardMicrophotoMouseover);
  /* стало не нужно
   $('body').mousemove(function (event) {
   $myApp.mouseCurrentX = event.pageX;
   $myApp.mouseCurrentY = event.pageY;
   });
   */
}

const EXT_CARD_STATUS = "ext_card_status";

function carCardMouseover(event) {
  let card = $(this), carId = card.attr("carid");
  if (carId == undefined || card.attr(EXT_CARD_STATUS) == "active") return;

  if (card.attr("ext_card_id")) {   // extCard уже есть
    let cardWidth = card.width(), cardCoords = card.offset(),
      extCard = $("#" + card.attr("ext_card_id"));
    $(".extended_car_card").each(function (index, elem) {
      if ($(elem).attr("id") != extCard.attr("id")) $(elem).addClass("d-none");
      else $(elem).removeClass("d-none");
    });
    extCard.offset({ left: cardCoords.left - 3, top: cardCoords.top - 3 }).width(cardWidth + 6);
    $(".car_card[ext_card_status=active]").attr(EXT_CARD_STATUS, "");
    card.attr(EXT_CARD_STATUS, "active");
    return;
  }

  $.ajax({
    url     : "/get_extended_product_card_micro_photos",
    type    : "POST",
    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    data    : { id: carId },
    dataType: 'json'
  }).done(function (responseData, b, c) {                   // SUCCESS ******************************
    if (!responseData.success) {
      card.attr(EXT_CARD_STATUS, "");
      console.log('ERROR responseData.success = 0 / ', b, c);
      return
    }
    let microPhotos = extCard.find(".ext_card_empty_img");
    extCard.find(".ext_car_card_microphoto_set").html(responseData.html)
  }).fail(function (jqXHR, status, errorThrown) {            // ERROR ******************************
    card.attr(EXT_CARD_STATUS, "");
    console.log('carCardMouseover > ОШИБКА AJAX запроса: ' + status, jqXHR);
  });

  let extCardId = "ext_car_card" + carId,
    cardWidth = card.width(), cardCoords = card.offset();

  let extCard = $("#" + extCardId);
  if (!extCard.length) {
    extCard = $('#extCard_FOR_CLONE').clone();
    extCard.attr("id", extCardId)
    $('body').append(extCard);
  }
  // копирую инфу из car_card в ext_car_card           -             -             -
  extCard.find(".card-img-top").attr("src", card.find(".card-img-top").attr("src"));
  extCard.attr("card_id", card.attr("id"));
  let url = card.find(".card_url").attr("href");
  extCard.find(".card_url").attr("href", url);
  extCard.find("a.btn").attr("href", url);
  extCard.find(".card-body").html(card.find(".card-body").html());
  extCard.find(".card-body").append(card.find(".icon_compare").get(0).outerHTML);
  extCard.find(".card-body").append(card.find(".icon_favorite").get(0).outerHTML);
  extCard.find(".icon_compare").addClass("ext_card_icons");
  extCard.find(".icon_favorite").addClass("ext_card_icons");
  //             -             -             -             -             -             -
  card.attr("ext_card_id", extCardId);
  $(".extended_car_card").each(function (index, elem) {
    if ($(elem).attr("id") != extCard.attr("id")) $(elem).addClass("d-none");
    else $(elem).removeClass("d-none");
  });
  extCard.offset({ left: cardCoords.left - 3, top: cardCoords.top - 3 }).width(cardWidth + 6);
  $(".car_card[ext_card_status=active]").attr(EXT_CARD_STATUS, "");
  card.attr(EXT_CARD_STATUS, "active");
}

function extCardMouseout(event) {
  event.stopImmediatePropagation();
  let thiss = $(this), cardId = thiss.attr("card_id");
  if (isMouseOverObject(event.pageX, event.pageY, thiss)) return;
  thiss.addClass("d-none");
  $("#" + cardId).attr(EXT_CARD_STATUS, "");
}

function isMouseOverObject(mouseX, mouseY, objJQ) {
  let coords = objJQ.offset(), rightX = coords.left + objJQ.width(), rightY = coords.top + objJQ.height();
  return (mouseX >= coords.left && mouseX <= rightX && mouseY >= coords.top && mouseY <= rightY);
}
// ··············································································

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function extendedCarCardMicrophotoMouseover(event) {
  let thiss = $(this), extCard = find_parent(thiss, "extended_car_card"), mainPhoto = extCard.find("img.ext_car_card_photo");
  mainPhoto.attr("src", thiss.attr("src"));
}

export { init }