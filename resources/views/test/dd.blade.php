<div>
	<?php
	$files = request()->all()["files"];
	foreach ($files as $file) {
		dump($file->getClientOriginalName());
	}
	?>
</div>