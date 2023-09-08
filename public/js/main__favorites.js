import * as SortmodePerpage from "./modules/sortmode_perpage.js";
import * as Search from "./modules/search.js";
import * as Favorites from "./modules/favorites.js";

$(function () {
  SortmodePerpage.init();
  Search.init();
  Favorites.init();

});
