function init() {
  // Dropzone инициализируется в content.blade.php, поскольку там надо указывать фразы с переводом на языки
  initDropzone();
  // click on the Send and Clear Data buttons
  $(document).on("submit", "#edit_form", send_dataClickHandler);
  $(document).on("click", ".btn_clear_data", clearData);
  $(document).on("change", "#car_brand", changeCarModelDatalist);
  // $(document).on("click", ".dz-remove", deletePhotoFromDropzoneAndServer);
  $(document).on("click", ".btn-remove-old-photo", deleteOldPhotoFromDropzone);
  $(document).on("change", ".is-invalid", changeIsInvalidHandler);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function changeIsInvalidHandler() {
  $(this).removeClass("is-invalid");
}


// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function send_dataClickHandler(event) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit
  var thumbnails = $(".dz-preview:not(.d-none)");
  if (!thumbnails.length) { /* нету фоток, вывести ошибку и прекратить выполнение*/
    $("#error_holder .error_text").text($(".error_message_no_photos").text());
    $("#error_holder").removeClass("d-none");
    return;
  }

  $("#loader_black_rect_fullscreen").removeClass("d-none");
  var thumbnailsWithDeleted = $(".dz-preview");
  var photosArray = new Set;
  for (let i = 0; i < thumbnailsWithDeleted.length; i++) {
    let file = {};
    file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
    var status = thumbnailsWithDeleted.eq(i).attr("file_status");
    switch (thumbnailsWithDeleted.eq(i).attr("file_status")) {
      case "old" :
        file.status = "old";
        file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
        break;
      case "del" :
        file.status = "del";
        file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
        break;
      default  :
        file.status = "new";
        file["filename"] = thumbnailsWithDeleted.eq(i).find("span[data-dz-name]").text();
        break;
    }
    photosArray.add(file);
  }
  // таким образом на сервер передаются список файлов и их статус
  $("input[name=photo_filenames]").val(JSON.stringify(Array.from(photosArray.values())));

  // создадим объект данных формы
  var data = new FormData(document.forms.edit_form),
    url = new URL(window.location.href).pathname;

  // AJAX запрос
  $.ajax({
    url        : url,
    type       : 'POST',
    headers    : {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data       : data,
    cache      : false, // dataType: 'json',
    processData: false, // отключаем обработку передаваемых данных, пусть передаются как есть
    contentType: false, // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
    // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
    success: function (response, status, jqXHR) {
      window.location.href = response.location;
    },
    // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
    error: function (jqXHR, status, errorThrown) {
      $("#loader_black_rect_fullscreen").addClass("d-none");
      console.log('send_dataClickHandler  ОШИБКА:', jqXHR);
      switch (jqXHR.status) {
        case 550 : // сервер не получил фотки (странно). Юзеру надо загрузить фотки в dropzone
        case 551 : // проблема с фотками. Юзеру надо заново загрузить фотки в dropzone
          $("#error_holder").removeClass("d-none");
          $("#error_holder .error_text").text(jqXHR.responseJSON.message);
          $(".dz-preview").each(function (index, elem) {
            $(elem).remove();
          });
          $("#dropzone_placement").removeClass("dz-started");
          break;
        case 422 : // Введённые данные не прошли валидацию
          console.log("INPUT DATA HAS NOT BEEN VALIDATED");
          Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
            if (key == "message") return;
            if (!Array.isArray(jqXHR.responseJSON.errors[key])) return;
            console.log(" -> ", jqXHR.responseJSON.errors[key][0]);
            if (key == "car_color") $("#select_color_title").addClass("is-invalid");
            else $("[name=" + key + "]").addClass("is-invalid");
            $("#error_holder .error_text").text($(".error_message_some_input_invalid").text());
            $("#error_holder").removeClass("d-none");
          });
          break;
        default:
          $("#error_holder .error_text").text($(".error_message_unknown").text());
          $("#error_holder").removeClass("d-none");
          break;
      }
    }
  });
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// в content.blade.php лежит присвоение $myApp.dictDefaultMessage, чтобы получить перевод этой фразы
function initDropzone() {
  // Dropzone.discover();
  $myApp.myDropzone = new Dropzone("#dropzone_placement", {
      // paramName         : "file", // The name that will be used to transfer the file
      url               : "/photo-upload",
      addRemoveLinks    : true,
      filesizeBase      : 1024,
      maxFilesize       : 15, // MB
      maxFiles          : 50,
      acceptedFiles     : `image/*`,
      previewsContainer : "#dropzone_placement",
      thumbnailMethod   : "contain",
      thumbnailWidth    : 180,
      thumbnailHeight   : 180,
      dictCancelUpload  : "",
      dictRemoveFile    : `<svg width="1rem" height="1rem"><use xlink:href="#i_close_mini"></use></svg>`,
      dictDefaultMessage: $myApp.dictDefaultMessage,
      // resizeMethod  : "contain",
      init          : function () {

        if ($(".dz-preview").length > 0) $("#dropzone_placement").addClass("dz-started");
        // добавляю огромную иконку в dropzone
        $(".dz-default.dz-message").prepend($(".drag_drop_big_icon"));
        // добавляю возможность перетягивать миниатюры внури dropzone
        $('.dropzone').sortable({
          animation: 250,
          draggable: ".dz-preview",
        });
      },
      accept        : function (file, done) {
        // console.log("accept -> " + file.name);
        done();
      },
      success       : function (file) {
        /*
         if (file.previewElement) {
         return file.previewElement.classList.add("dz-success");
         }*/
        $("#error_holder").addClass("d-none");
      },
      error         : errorUploadPhoto,
      sending       : function (file, xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
      },
      reset         : function () {
      },
      renameFile    : function (file) {
        console.log("renameFile -> ", file.name);
      },
      renameFilename: function (file) {
        return $("input[name=id_for_link_form_and_uploaded_photos]").val() + "_-_-_" + file;
      },
      removedfile   : deletePhotoFromDropzoneAndServer,
    }
  );
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function deletePhotoFromDropzoneAndServer(file) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit

  var filename = file.name,
    id_for_link_form_and_uploaded_photos = $("input[name=id_for_link_form_and_uploaded_photos]").val(),
    thumbnail = $(file.previewElement),
    dataToSend = {
      filename                            : filename,
      id_for_link_form_and_uploaded_photos: id_for_link_form_and_uploaded_photos
    }

  $.ajax({
    url     : '/delete-uploaded-photo',
    type    : 'POST',
    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    data    : dataToSend,
    dataType: 'json',
    success : function (response, status, jqXHR) {
      removeOneThumbnailFromDropzone(thumbnail);
    },
    error   : function (jqXHR, status, errorThrown) { // функция ошибки ответа сервера
      console.log('deletePhotoFromDropzoneAndServer  ОШИБКА : ' + status, jqXHR);
    }
  });
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function deleteOldPhotoFromDropzone(event) {
  var
    thumbnail = find_parent($(this), "dz-preview"),
    filename = thumbnail.attr("file_name"),
    status = thumbnail.attr("file_status");

  if (status != "old") return;
  thumbnail.attr("file_status", "del")
  thumbnail.animate({ width: '0px', height: "0px" }, 200, function () {
    $(this).addClass("d-none");
    // если не осталось ни одной миниатюры, то надо включить dropzone
    if (!$(".dz-preview:not(.d-none)").length) $("#dropzone_placement").removeClass("dz-started");
  });
}

// вызывается, если сервер вернул ошибку при загрузке фотки
function errorUploadPhoto(file, message) {
  var thumbnail = find_parent($("span[data-dz-name]").filter(function (index) {
    return $(this).text() == file.name;
  }).eq(0), "dz-preview");
  removeOneThumbnailFromDropzone(thumbnail);
  console.log("error -> ", file.name, message);
}

// изменение списка моделей машин после выбора брэнда
function changeCarModelDatalist(event) {
  if (typeof event == "string") {
    var brand = event;
  } else {
    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега
    var brand = $(this).val();
  }
  var carModelListHolder = $("#car_model_list"), modelsList = $myApp.carModels[brand];
  carModelListHolder.html("");
  $("#car_model").val("");
  for (let i = 0; i < modelsList.length; i++) {
    carModelListHolder.append($("<option value='" + modelsList[i] + "'></option>"));
  }
  // event.stopPropagation(); // остановка всех текущих JS событий
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function removeOneThumbnailFromDropzone(thumbnail) {
  thumbnail.animate({ width: '0px', height: "0px" }, 200, function () {
    $(this).remove();
    // если не осталось ни одной миниатюры, то надо включить dropzone
    if (!$(".dz-preview:not(.d-none)").length) $("#dropzone_placement").removeClass("dz-started");
  });
}

// очистка введенных данных в форме
function clearData(event) {
  var newBrandValue = $("#car_brand option").eq(0).val();
  $("#car_brand").val(newBrandValue);
  // $("#car_brand").val("");
  $("#car_model").val("");
  changeCarModelDatalist(newBrandValue);
  $("#car_gearbox").val($("#car_gearbox option").eq(0).val());
  $("#car_engine_type").val($("#car_engine_type option").eq(0).val());
  $("#car_engine_capacity").val("");
  $("#car_engine_power").val("");
  $("#car_fuel_consumption").val("");
  $("#car_body_type").val($("#car_body_type option").eq(0).val());
  $("#car_number_doors").val("");
  $("#car_number_places").val("");
  $(".x_color_selection input").prop("checked", false);
  $("#car_clearance").val("");
  $("#car_wheelbase").val("");
  $("#car_length").val("");
  $("#car_width").val("");
  $("#car_height").val("");
  $("#car_production_year").val("");
  $("#car_mileage").val("");
  $("#was_in_accident_no").prop("checked", true);
  $("#was_in_accident_yes").prop("checked", false);
  $("#car_price").val("");
  $("#car_description").val("");
}

export { init }