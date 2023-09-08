@props (["title","color"])<?php
                          switch ($color) {
	                          case "green" :
		                          $classes = "card-success";
		                          break;
	                          case "red" :
		                          $classes = "card-danger";
		                          break;
	                          case "yellow" :
		                          $classes = "card-warning";
		                          break;
	                          default:
	                          case "blue" :
		                          $classes = "card-primary";
		                          break;
                          }

                          ?>
<div class="card card_create_car {{$classes}}">
	<div class="card-header">
		<h3 class="card-title">{{$title}}</h3>
	</div>
	<div class="card-body">{{$slot}}</div>
</div>
