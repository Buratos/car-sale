<!DOCTYPE html>
<html lang="en">
<head>
	@yield("tag_head")
</head>
<body class="">
<x-myapp_init__CARS/>
@yield("header__logo_search_auth_menu")     {{--▪▪▪  HEADER  ШАПКА и МЕНЮ  ▪▪▪--}}
@yield("content")
@yield("footer")
@yield("switch_language")
</body>
@yield("storage__svg_icons")
</html>
