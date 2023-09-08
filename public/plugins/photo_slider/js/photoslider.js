$(function () {

  // обработчики для photoslider
  $(document).on("click", ".btn-photoslider-prev", { target: "btn-photoslider-prev" }, photoslider_click_handler);
  $(document).on("click", ".btn-photoslider-next", { target: "btn-photoslider-next" }, photoslider_click_handler);
  $(document).on("click", ".btn-photoslider-prev-mini", { target: "btn-photoslider-prev-mini" }, photoslider_click_handler);
  $(document).on("click", ".btn-photoslider-next-mini", { target: "btn-photoslider-next-mini" }, photoslider_click_handler);
  $(document).on("click", ".photoslider-mini-item", { target: "photoslider-mini-item" }, photoslider_click_handler);

  // НА ТЕЛЕФОНЕ для перетягивания слайдов карусели пальцем
  window.slide_dragging_touchstart = false;
  $(document).on("touchstart", ".photoslider_items_holder", slide_touchstart);
  $(document).on("touchmove	", ".photoslider_items_holder", slide_touchmove);
  $(document).on("touchend", ".photoslider_items_holder", slide_touchend);

  // для распахиваания слайда на весь экран и последующего его скрытия
  $(document).on("click", ".photoslider_items_holder", slide_open_to_fullscreen);
  $(document).on("click", ".photoslider_fullscreen", photoslider_fullscreen_close);


  /**▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀
   далее идут внутренние функции типа обработчиков событий и остального
   ▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄*/

  function photoslider_keyup(event) {
    clog(`нажата кнопка - ${event.code} - и event.key - ${event.key}`);
    var slides = $(".photoslider_items_holder .photoslider-item");
    var slides_quan = slides.length;
    var active_slide = $(".photoslider_items_holder .photoslider-item.active");
    var active_slide_num = +active_slide.attr("number"), new_active_slide;

    switch (event.code) {
      case "ArrowLeft" :
        event.stopImmediatePropagation();

        if (active_slide_num == 1) new_active_slide = slides.eq(slides_quan - 2); else new_active_slide = slides.eq(active_slide_num - 1);
        // анимация смены слайдов
        active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last");
        active_slide.removeClass("active").addClass("photoslider_hide_left_to_right");

        new_active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last");
        new_active_slide.addClass("photoslider_show_left_to_right active");
        break;
      case "ArrowRight" :
        event.stopImmediatePropagation();

        if (active_slide_num == slides_quan - 2) new_active_slide = slides.eq(1); else new_active_slide = slides.eq(active_slide_num + 1);
        // анимация смены слайдов
        active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
        active_slide.removeClass("active").addClass("photoslider_hide_right_to_left");

        new_active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
        new_active_slide.addClass("photoslider_show_right_to_left active");
        break;
      case "Escape" :
        photoslider_fullscreen_close(event)
      default:
        return;
    }
    // создаю полноэкранный слайд на черном фоне
    $(".fullscreen_slide_holder").html($(".photoslider_items_holder .photoslider-item.active")[0].outerHTML);
    $(".fullscreen_slide_holder .photoslider-item").removeClass("photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last").addClass("left0 vh-100");
    $(".fullscreen_slide_holder .photoslider-image").addClass("vh-100");
    $(".fullscreen_slide_holder .photoslider-item-title-and-text").addClass("bottom3rem");

    // обрабатываю полосу мини фоток
    photoslider_mini_items_process("btn-photoslider-next", this);
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // закрывает режим просмотра fullscreen
  function photoslider_fullscreen_close(event) {
    $(document).off("keyup", photoslider_keyup);
    $(".photoslider_fullscreen").fadeOut(200);
    $(".fullscreen_slide_holder").html("");
    event.stopImmediatePropagation();
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // открывает слайд в фуллскрине
  function slide_open_to_fullscreen() {
    if (isMobileViewport()) return;
    $(document).on("keyup", photoslider_keyup);

    $(".fullscreen_slide_holder").html($(".photoslider-item.active")[0].outerHTML);
    $(".fullscreen_slide_holder .photoslider-item").removeClass("photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last").addClass("left0 vh-100");
    $(".fullscreen_slide_holder .photoslider-image").addClass("vh-100");
    $(".fullscreen_slide_holder .photoslider-item-title-and-text").addClass("bottom3rem");

    $(".photoslider_fullscreen").fadeIn(200);
  }

  // ■■■■■■■■■■■■ обработчики событий для свайпа по слайду
  // прикосновеник пальца, палец еще прижат к экрану
  function slide_touchstart(event) {
    window.slide_dragging_touchstart = true;
    window.slide_dragging_touchstart_x = event.changedTouches[0].pageX;
    event.stopImmediatePropagation();
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // палец движется по экрану
  function slide_touchmove(event) {
    var active_slide_num = +$(".photoslider-item.active").attr("number");
    var css_str = (window.slide_dragging_touchstart_x > event.changedTouches[0].pageX) ? ("calc(-" + (active_slide_num - 1) * 100 + "% - " + (window.slide_dragging_touchstart_x - event.changedTouches[0].pageX) + "px)") : ("calc(-" + (active_slide_num - 1) * 100 + "% + " + (event.changedTouches[0].pageX - window.slide_dragging_touchstart_x) + "px)");
    this.style.marginLeft = css_str;
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  function redraw_miniitems() {
    const mini_item_width = 70, mini_item_left_margin = 8;
    var active_slide_num = +$(".photoslider-item.active").attr("number");
    var active_slide_x = 40 + (active_slide_num - 1) * (mini_item_width + mini_item_left_margin);
    var miniitems_wrapper = $(".photoslider_miniitems_wrapper");
    var visible_part_start_x = miniitems_wrapper[0].scrollLeft + 1, visible_part_end_x = visible_part_start_x + miniitems_wrapper.width();

    // если слайд в полной мере не попадает в зону видимости, пеперисовываю
    if ((active_slide_x < visible_part_start_x) || (active_slide_x >= visible_part_start_x && (active_slide_x + mini_item_width) > visible_part_end_x) || (active_slide_x >= visible_part_end_x)) {
      switch (active_slide_num) {
        case 1 :
          miniitems_wrapper[0].scrollTo({
            left    : 0,
            top     : miniitems_wrapper[0].scrollTop,
            behavior: 'smooth'
          });
          break;
        case $(".photoslider-item").length :
          miniitems_wrapper[0].scrollTo({
            left    : $(".photoslider_miniitems_holder").width() - miniitems_wrapper.width(),
            top     : miniitems_wrapper[0].scrollTop,
            behavior: 'smooth'
          });
          break;
        default:
          miniitems_wrapper[0].scrollTo({
            left    : active_slide_x - (miniitems_wrapper.width() - mini_item_width) / 2,
            top     : miniitems_wrapper[0].scrollTop,
            behavior: 'smooth'
          });
          break;
      }
    }
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // конец свайпа, палец оторван от экрана
  function slide_touchend(event) {
    var thiss = $(this);
    window.slide_dragging_touchstart = false;

    var swipe = (window.slide_dragging_touchstart_x > event.changedTouches[0].pageX) ? {
      direction: "SWIPE LEFT",
      length   : window.slide_dragging_touchstart_x - event.changedTouches[0].pageX
    } : {
      direction: "SWIPE RIGHT",
      length   : event.changedTouches[0].pageX - window.slide_dragging_touchstart_x
    };
    var active_slide_num = +$(".photoslider-item.active").attr("number");
    var slides = $(".photoslider-item");

    if (swipe.length > 50) {       // свайп длиннее 50px - передвигаем фотки
      $(".photoslider-mini-item.active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
      switch (swipe.direction) {
        case "SWIPE LEFT" :                      // свайп ВЛЕВО
          if (active_slide_num < slides.length - 2) {
            var css_str = "-" + (active_slide_num - 0) * 100 + "%";
            thiss.animate({ marginLeft: css_str }, 250, "linear");
            $(".photoslider-item.active").removeClass("active");
            slides.eq(active_slide_num + 1).addClass("active");
            $(".photoslider-mini-item").eq(active_slide_num).addClass("active_photoslider_mini_item");
          } else {
            // если активен последний кадр, то надо перескакивать на противополодный край
            // ПЛАВНО перенести на начало слайда
            // а затем МГНОВЕННО перенести на противоположный край
            var css_str = "-" + active_slide_num * 100 + "%";
            thiss.animate({ marginLeft: css_str }, 250, "linear", function () {
              thiss.css("transition-property", "margin-left");
              thiss.css("transition-duration", "0s");
              thiss.css("margin-left", "0");
            });
            $(".photoslider-item.active").removeClass("active");
            slides.eq(1).addClass("active");
            $(".photoslider-mini-item").eq(0).addClass("active_photoslider_mini_item");
          }
          break;
        case "SWIPE RIGHT" :               // свайп ВПРАВО
          if (active_slide_num > 1) { // если активен 2й слайд или больше, то ...
            var css_str = "-" + (active_slide_num - 2) * 100 + "%";
            thiss.animate({ marginLeft: css_str }, 250, "linear", function () {
            });

            $(".photoslider-item.active").removeClass("active");
            slides.eq(active_slide_num - 1).addClass("active");
            $(".photoslider-mini-item").eq(active_slide_num - 2).addClass("active_photoslider_mini_item");

          } else {
            // если активен 1й кадр, то надо перескакивать на противополодный край
            // ПЛАВНО перенести на начало слайда
            // а затем МГНОВЕННО перенести на противоположный край
            thiss.animate({ marginLeft: "100%" }, 250, "linear", function () {
              thiss.css("transition-property", "margin-left");
              thiss.css("transition-duration", "0s");
              thiss.css("margin-left", "-" + (slides.length - 3) * 100 + "%");
            });

            $(".photoslider-item.active").removeClass("active");
            slides.eq(slides.length - 2).addClass("active");
            $(".photoslider-mini-item").eq($(".photoslider-mini-item").length - 1).addClass("active_photoslider_mini_item");

          }
          break;
      }
      // надо перерисовать mini-items, чтобы активный был на виду
      redraw_miniitems();

    } else if (swipe.length > 0) {         // свайп короче 50px - возвращаем фотку на место
      var css_str = "-" + (active_slide_num - 1) * 100 + "%";
      thiss.animate({ marginLeft: css_str }, 250, "linear", function () {
      })
    }
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // обработка любых кликов по карусели
  function photoslider_click_handler(event) {
    var slides = $(".photoslider-item");
    var slides_quan = slides.length;
    var active_slide = $(".photoslider-item.active");
    var active_slide_num = +active_slide.attr("number"), new_active_slide;
    event.stopImmediatePropagation();

    switch (event.data.target) {
      case "btn-photoslider-prev" :             /* КНОПКА ВЛЕВО PREV */
        if ($(this).hasClass("btn-photoslider-fullscr")) {
          // это fullscreen, а потому передаю обработку в photoslider_keyup()
          event.code = "ArrowLeft";
          photoslider_keyup(event);
        } else {
          if (active_slide_num == 1) new_active_slide = slides.eq(slides_quan - 2); else new_active_slide = slides.eq(active_slide_num - 1);

          // анимация смены слайдов
          active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last");
          active_slide.removeClass("active").addClass("photoslider_hide_left_to_right");

          new_active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left photoslider_1st_to_last");
          new_active_slide.addClass("photoslider_show_left_to_right active");

          // обрабатываю полосу мини фоток
          photoslider_mini_items_process(event.data.target, this);
        }
        break;

      case "btn-photoslider-next" :             /* КНОПКА ВПРАВО NEXT */
        if ($(this).hasClass("btn-photoslider-fullscr")) {
          // это fullscreen, а потому передаю обработку в photoslider_keyup()
          event.code = "ArrowRight";
          photoslider_keyup(event);
        } else {
          if (active_slide_num == slides_quan - 2) new_active_slide = slides.eq(1); else new_active_slide = slides.eq(active_slide_num + 1);
          // анимация смены слайдов
          active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
          active_slide.removeClass("active").addClass("photoslider_hide_right_to_left");

          new_active_slide.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
          new_active_slide.addClass("photoslider_show_right_to_left active");

          // обрабатываю полосу мини фоток
          photoslider_mini_items_process(event.data.target, this);
        }
        break;

      case "btn-photoslider-prev-mini" :
        photoslider_mini_items_process(event.data.target, this);
        break;

      case "btn-photoslider-next-mini" :
        photoslider_mini_items_process(event.data.target, this);
        break;

      case "photoslider-mini-item" :             /* клик по МИНИМ ФОТКЕ */
        photoslider_mini_items_process(event.data.target, this);
        break;
    }
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  function photoslider_mini_items_process(event_class, thiss) {
    const mini_item_width = 70, mini_item_left_margin = 8;
    switch (event_class) {
      case "btn-photoslider-prev" :             /* КНОПКА ВЛЕВО PREV */
        var active_slide_num = $(".photoslider-item.active").attr("number");

        // обрабатываю полосу мини фоток
        $(".photoslider-mini-item.active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
        var active_photoslider_mini_item = $(".photoslider-mini-item").eq(active_slide_num - 1);
        active_photoslider_mini_item.addClass("active_photoslider_mini_item");
        redraw_miniitems();
        break;

      case "btn-photoslider-next" :             /* КНОПКА ВПРАВО NEXT */
        var active_slide_num = $(".photoslider-item.active").attr("number");
        if (active_slide_num == $(".photoslider-item").length) break;

        // обрабатываю полосу мини фоток
        $(".photoslider-mini-item.active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
        $(".photoslider-mini-item").eq(active_slide_num - 1).addClass("active_photoslider_mini_item");
        redraw_miniitems();
        break;

      case "btn-photoslider-prev-mini" :
        var photoslider_miniitems_wrapper = $(".photoslider_miniitems_wrapper")[0];
        if (isMobileViewport()) {
          photoslider_miniitems_wrapper.scrollTo({
            left    : 0,
            top     : photoslider_miniitems_wrapper.scrollTop,
            behavior: 'smooth'
          });
        } else {
          var scroll_left = photoslider_miniitems_wrapper.scrollLeft - (mini_item_width + mini_item_left_margin) * 3;
          photoslider_miniitems_wrapper.scrollTo({
            left    : scroll_left,
            top     : photoslider_miniitems_wrapper.scrollTop,
            behavior: 'smooth'
          });
        }
        break;

      case "btn-photoslider-next-mini" :
        var photoslider_miniitems_wrapper = $(".photoslider_miniitems_wrapper")[0];
        if (isMobileViewport()) {
          $(".photoslider_miniitems_wrapper")[0].scrollTo({
            left    : $(".photoslider_miniitems_holder").width() - $(".photoslider_miniitems_wrapper").width(),
            top     : $(".photoslider_miniitems_wrapper")[0].scrollTop,
            behavior: 'smooth'
          });
        } else {
          var scroll_left = photoslider_miniitems_wrapper.scrollLeft + (mini_item_width + mini_item_left_margin) * 3;
          photoslider_miniitems_wrapper.scrollTo({
            left    : scroll_left,
            top     : photoslider_miniitems_wrapper.scrollTop,
            behavior: 'smooth'
          });
        }
        break;

      case "photoslider-mini-item" :             /* клик по МИНИ ФОТКЕ */
        var clicked_mini_item = $(thiss);
        if (clicked_mini_item.hasClass("active_photoslider_mini_item")) break;
        var clicked_mini_item_num = +clicked_mini_item.attr("number");
        var active_item = $(".photoslider-item.active");
        var active_item_num = +active_item.attr("number");
        var new_active_item = $(`.photoslider-item[number="${clicked_mini_item_num}"]`);

        if (isMobileViewport()) {
          active_item.removeClass("active");
          $(".photoslider-item").eq(clicked_mini_item_num).addClass("active");
          $(".active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
          clicked_mini_item.addClass("active_photoslider_mini_item");

          var css_str = "-" + (clicked_mini_item_num - 1) * 100 + "%";
          $(".photoslider_items_holder").animate({ marginLeft: css_str }, 250, "linear");

        } else {            // если это НЕ телефон
          if (clicked_mini_item_num < active_item_num) {    // скроллинг слева на право
            // неактивный слайд уезжает
            active_item.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
            active_item.removeClass("active").addClass("photoslider_hide_left_to_right");
            // новый активный слайд заезжает
            new_active_item.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
            new_active_item.addClass("photoslider_show_left_to_right active");

            // обрабатываю полосу мини фоток
            $(".photoslider-mini-item.active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
            clicked_mini_item.addClass("active_photoslider_mini_item");
          } else {                                        // скроллинг справа на лево
            // неактивный слайд уезжает
            active_item.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
            active_item.removeClass("active").addClass("photoslider_hide_right_to_left");
            // новый активный слайд заезжает
            new_active_item.removeClass("left0 photoslider_hide_left_to_right photoslider_show_left_to_right photoslider_hide_right_to_left photoslider_show_right_to_left");
            new_active_item.addClass("photoslider_show_right_to_left active");

            // обрабатываю полосу мини фоток
            $(".active_photoslider_mini_item").removeClass("active_photoslider_mini_item");
            clicked_mini_item.addClass("active_photoslider_mini_item");
          }
          redraw_miniitems();
        }
        break;
    }
  }

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
  // отрезает от конца 2 символа в строках типа "149.242px" и возвращает ЧИСЛО (не строку)
  function cutoff__px(str) {
    return +str.slice(0, str.length - 2);
  }

});
