<div class="container">
	<div class="row">
		<div class="col d-flex justify-content-center column">
			<?php
			$test = ["111111 строка", "22222 string", "333 str"];
			?>
			<x-test_array_param name="** это props name **" class="text-bg-dark text-white" id="test_id" :options="$test">
				<p>Отдельный абзац</p>
			</x-test_array_param>
		</div>
	</div>
</div>
<script type="text/javascript">
	{{--$myApp.carModels = <?php echo json_encode($models) ?>;--}}
</script>
