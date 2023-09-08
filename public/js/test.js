$(function () {
  if (history.pushState) {
/*
    console.log(window.location.href);
    // var newUrl = window.location.origin;
    var url = "http://car-sale/test?ff=f102-f107-f109-f118-f119-f121-f447&fd=f446_2630_3106";
    var newUrl = window.location.href;
    console.log(url);
*/
    var url = new URL(window.location.href);
    console.log(url.toString());
    url.searchParams.set("ff", "f105-f106");
    url.searchParams.delete("fd");
    console.log(url.toString());


  } else {
    console.warn('History API is not supported by your browser');
  }
});

