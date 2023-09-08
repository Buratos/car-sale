import * as SortmodePerpage from "./modules/sortmode_perpage.js";
import * as Filters from "./modules/filter_management.js";
import * as ProductCardIcons from "./modules/product_card_icons_management.js";
import * as ExtendedCarCard from "./modules/extended_car_card.js";
import * as Search from "./modules/search.js";

$(function () {
  SortmodePerpage.init();
  Filters.init();
  ProductCardIcons.init();
  if (!isMobileViewport()) ExtendedCarCard.init();
  Search.init();  
});
