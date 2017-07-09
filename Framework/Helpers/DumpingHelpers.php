<?php 

if (!function_exists('sd')) {
	function sd($args)
	{
		$dumpArr = func_get_args($args);

		foreach ($dumpArr as $dump) {
			echo '<pre>';
			var_dump($dump);
			echo "\n----------------------------\n";
			echo '</pre>';
		}
		die();
	}
}
