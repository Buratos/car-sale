jQuery(document).ready(function ($) {

  /*
   $.getScript("/js/includes/init_sortMode_perPage_URL.js").fail(function (jqxhr, settings, exception) {
   console.log("/js/includes/init_sortMode_perPage_URL.js", "НЕ смог загрузиться.\r\n Проблема:", exception);
   });
   */
  /*
   $.getScript("/js/includes/carCardIconsClickHandler.js").fail(function (jqxhr, settings, exception) {
   console.log("/js/includes/carCardIconsClickHandler.js", "НЕ смог загрузиться.\r\n Проблема:", exception);
   });
   */

  $(document).on("click", "#clear_compare", { func: "clear_compare" }, compareClickHandler);

  function compareClickHandler(event) {
    event.stopImmediatePropagation();
    var thiss = $(this);

    switch (event.data.func) {
      case "clear_compare":
        $.cookie($myApp.productName + "_compare_elems", JSON.stringify([]), { expires: 15, path: '/' });
        // надо удалить весь блок контента с экрана
        var content = $(".content");
        content.animate({ width: '0px', height: "0px" }, 200, function () {
            $(".no_cars_in_compare").removeClass("d-none");
            $(this).remove();
          }
        );
        break;
    }
  }

  function productsTable(element) {
    this.element = element;
    this.table = this.element.children('.cd-products-table');
    this.tableHeight = this.table.height();
    this.productsWrapper = this.table.children('.cd-products-wrapper');
    this.tableColumns = this.productsWrapper.children('.cd-products-columns');
    this.products = this.tableColumns.children('.product');
    this.productsNumber = this.products.length;
    this.productWidth = this.products.eq(0).width();
    this.productsTopInfo = this.table.find('.top-info');
    this.featuresTopInfo = this.table.children('.features').children('.top-info');
    this.topInfoHeight = this.featuresTopInfo.innerHeight() + 30;
    this.leftScrolling = false;
    // this.selectedproductsNumber = 0;
    this.navigation = this.table.children('.cd-table-navigation');
    // bind table events
    this.bindEvents();
    this.tableColumns.css('width', this.productWidth * this.productsNumber + 1 + 'px');

  }

  productsTable.prototype.bindEvents = function () {
    var self = this;
    //detect scroll left inside producst table
    self.productsWrapper.on('scroll', function () {
      if (!self.leftScrolling) {
        self.leftScrolling = true;
        (!window.requestAnimationFrame) ? setTimeout(function () {
          self.updateLeftScrolling();
        }, 250) : window.requestAnimationFrame(function () {
          self.updateLeftScrolling();
        });
      }
    });
    // клик по кружку удаления элемента
    self.products.on('click', '.btn_delete_compare_elem', function (event) {
      event.stopImmediatePropagation();
      event.stopPropagation();

      var carId = $(this).attr("carid"), compareElems = [], cookie = $.cookie($myApp.productName + "_compare_elems");
      if (cookie) compareElems = JSON.parse(cookie);
      compareElems = new Set(compareElems);
      compareElems.delete(carId);
      $.cookie($myApp.productName + "_compare_elems", JSON.stringify(Array.from(compareElems)), { expires: 15, path: '/' });

      var product = find_parent($(this), 'product');
      product.animate({ width: '0px' }, 200, function () {
        product.remove();
        var products = $(".cd-products-wrapper .product");
        if (products.length == 0) {
          $(".content").addClass("d-none");
          $(".no_cars_in_compare").removeClass("d-none");
        } else $(".cd-products-wrapper .cd-products-columns").css('width', products.eq(0).width() * products.length + 1 + 'px');
      });

    });

    //scroll inside products table
    this.navigation.on('click', 'a', function (event) {
      event.preventDefault();
      self.updateSlider($(event.target).hasClass('next'));
    });
  }


  productsTable.prototype.updateLeftScrolling = function () {
    var totalTableWidth = parseInt(this.tableColumns.eq(0).outerWidth(true)),
      tableViewport = parseInt(this.element.width()),
      scrollLeft = this.productsWrapper.scrollLeft();

    (scrollLeft > 0) ? this.table.addClass('scrolling') : this.table.removeClass('scrolling');

    if (this.table.hasClass('top-fixed') && checkMQ() == 'desktop') {
      setTranformX(this.productsTopInfo, '-' + scrollLeft);
      setTranformX(this.featuresTopInfo, '0');
    }

    this.leftScrolling = false;

    this.updateNavigationVisibility(scrollLeft);
  }

  productsTable.prototype.updateNavigationVisibility = function (scrollLeft) {
    (scrollLeft > 0) ? this.navigation.find('.prev').removeClass('inactive') : this.navigation.find('.prev').addClass('inactive');
    (scrollLeft < this.tableColumns.outerWidth(true) - this.productsWrapper.width() && this.tableColumns.outerWidth(true) > this.productsWrapper.width()) ? this.navigation.find('.next').removeClass('inactive') : this.navigation.find('.next').addClass('inactive');
  }

  productsTable.prototype.updateTopScrolling = function (scrollTop) {
    var offsetTop = this.table.offset().top,
      tableScrollLeft = this.productsWrapper.scrollLeft();

    if (offsetTop <= scrollTop && offsetTop + this.tableHeight - this.topInfoHeight >= scrollTop) {
      //fix products top-info && arrows navigation
      if (!this.table.hasClass('top-fixed') && $(document).height() > offsetTop + $(window).height() + 200) {
        this.table.addClass('top-fixed').removeClass('top-scrolling');
        if (checkMQ() == 'desktop') {
          this.productsTopInfo.css('top', '0');
          this.navigation.find('a').css('top', '0px');
        }
      }

    } else if (offsetTop <= scrollTop) {
      //product top-info && arrows navigation -  scroll with table
      this.table.removeClass('top-fixed').addClass('top-scrolling');
      if (checkMQ() == 'desktop') {
        this.productsTopInfo.css('top', (this.tableHeight - this.topInfoHeight) + 'px');
        this.navigation.find('a').css('top', (this.tableHeight - this.topInfoHeight) + 'px');
      }
    } else {
      //product top-info && arrows navigation -  reset style
      this.table.removeClass('top-fixed top-scrolling');
      this.productsTopInfo.attr('style', '');
      this.navigation.find('a').attr('style', '');
    }

    this.updateLeftScrolling();
  }

  productsTable.prototype.updateProperties = function () {
    this.tableHeight = this.table.height();
    this.productWidth = this.products.eq(0).width();
    this.topInfoHeight = this.featuresTopInfo.innerHeight() + 30;
    this.tableColumns.css('width', this.productWidth * this.productsNumber + 1 + 'px');
  }

  productsTable.prototype.updateSlider = function (bool) {
    var scrollLeft = this.productsWrapper.scrollLeft();
    scrollLeft = (bool) ? scrollLeft + this.productWidth : scrollLeft - this.productWidth;

    if (scrollLeft < 0) scrollLeft = 0;
    if (scrollLeft > this.tableColumns.outerWidth(true) - this.productsWrapper.width()) scrollLeft = this.tableColumns.outerWidth(true) - this.productsWrapper.width();

    this.productsWrapper.animate({ scrollLeft: scrollLeft }, 200);
  }

  var comparisonTables = [];
  $('.cd-products-comparison-table').each(function () {
    //create a productsTable object for each .cd-products-comparison-table
    comparisonTables.push(new productsTable($(this)));
  });

  var windowScrolling = false;
  //detect window scroll - fix product top-info on scrolling
  $(window).on('scroll', function () {
    if (!windowScrolling) {
      windowScrolling = true;
      (!window.requestAnimationFrame) ? setTimeout(checkScrolling, 250) : window.requestAnimationFrame(checkScrolling);
    }
  });

  var windowResize = false;
  //detect window resize - reset .cd-products-comparison-table properties
  $(window).on('resize', function () {
    if (!windowResize) {
      windowResize = true;
      (!window.requestAnimationFrame) ? setTimeout(checkResize, 250) : window.requestAnimationFrame(checkResize);
    }
  });

  function checkScrolling() {
    var scrollTop = $(window).scrollTop();
    comparisonTables.forEach(function (element) {
      element.updateTopScrolling(scrollTop);
    });

    windowScrolling = false;
  }

  function checkResize() {
    comparisonTables.forEach(function (element) {
      element.updateProperties();
    });

    windowResize = false;
  }

  function checkMQ() {
    //check if mobile or desktop device
    return window.getComputedStyle(comparisonTables[0].element.get(0), '::after').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
  }

  function setTranformX(element, value) {
    element.css({
      'transform': 'translateX(' + value + 'px)'
    });
  }
});

