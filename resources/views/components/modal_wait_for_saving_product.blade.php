<?php
$loaderAnimationName = "loader_" . mt_rand(1, 3);
?>
<link href="{{asset('/css/loaders.css')}}" rel="stylesheet"/>
<div class="d-flex justify-content-center align-items-center d-none" id="loader_black_rect_fullscreen">
	<span class="{{$loaderAnimationName}}"></span>
</div>