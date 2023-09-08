{{-- этот файл надо для каждой страницы делать индивидуально
  еще надо добавить в файл robots.txt строки:
  
User-Agent: *
Allow: /
--}}{{--
	<meta name="description" content="Описание">
	<meta name="keywords" content="Ключевики">
	<meta name="author" content="Автор">
	<meta name="image" content="./img/logo.png">
	--}}
<meta property="og:type" content="website">
<meta property="og:title" content="CAR-SALE shop">
<meta property="og:description" content="Тренировочный проект, интернет магазин автомобилей">
<meta property="og:image" content="{{asset('/img/meta_tag/og_image.jpg')}}">
<meta property="og:url" content="{{route("cars.index")}}">{{--
	
	<link rel="canonical" href="https://example.com">
	
	<link rel="preconnect" href="//fonts.gstatic.com">
	<link rel="preconnect" href="//cdnjs.cloudflare.com">
	<link rel="preconnect" href="//google-analytics.com">
	
	<link rel="apple-touch-icon" sizes="57x57" href="./img/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="./img/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="./img/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="./img/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="./img/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="./img/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="./img/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="./img/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="./img/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="./img/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="./img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="./img/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="./img/favicon-16x16.png">
	<link rel="manifest" href="./img/manifest.json">
	
	<meta name="msapplication-TileImage" content="./img/ms-icon-144x144.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	
	<meta name="apple-mobile-web-app-title" content="Название">
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
	--}}
