<div class="dz-preview dz-processing dz-image-preview dz-complete" file_name="{{$photo->filename}}" file_status="old">
	<div class="dz-image">
		<img data-dz-thumbnail="" alt="" src="{{$photo->url}}">
	</div>
	<div class="dz-details">
		<div class="dz-size">
			<span data-dz-size=""><strong>30.7</strong> KB</span>
		</div>
		<div class="dz-filename">
			<span class="d-none" data-dz-name="">{{$photo->filename}}</span>
		</div>
	</div>
{{--
	<div class="dz-progress">
		<span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
	</div>
	<div class="dz-error-message">
		<span data-dz-errormessage=""></span>
	</div>
--}}
{{--
	<div class="dz-success-mark">
		<svg width="54" height="54" fill="#fff">
			<path d="m10.207 29.793 4.086-4.086a1 1 0 0 1 1.414 0l5.586 5.586a1 1 0 0 0 1.414 0l15.586-15.586a1 1 0 0 1 1.414 0l4.086 4.086a1 1 0 0 1 0 1.414L22.707 42.293a1 1 0 0 1-1.414 0L10.207 31.207a1 1 0 0 1 0-1.414Z"></path>
		</svg>
	</div>
--}}
{{--
	<div class="dz-error-mark">
		<svg width="54" height="54" fill="#fff">
			<path d="m26.293 20.293-7.086-7.086a1 1 0 0 0-1.414 0l-4.586 4.586a1 1 0 0 0 0 1.414l7.086 7.086a1 1 0 0 1 0 1.414l-7.086 7.086a1 1 0 0 0 0 1.414l4.586 4.586a1 1 0 0 0 1.414 0l7.086-7.086a1 1 0 0 1 1.414 0l7.086 7.086a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7.086-7.086a1 1 0 0 1 0-1.414l7.086-7.086a1 1 0 0 0 0-1.414l-4.586-4.586a1 1 0 0 0-1.414 0l-7.086 7.086a1 1 0 0 1-1.414 0Z"></path>
		</svg>
	</div>
--}}
	<a class="btn-remove-old-photo" href="javascript:undefined;">
		<svg width="1rem" height="1rem">
			<use xlink:href="#i_close_mini"></use>
		</svg>
	</a>
</div>
