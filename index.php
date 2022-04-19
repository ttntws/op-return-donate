<?php

require __dir__ . '/global.php';

use Jenssegers\Blade\Blade as Blade;

$blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

foreach(getComponentPaths('components') as $component) {
	$blade->compiler()->component("$component");
}

$request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'home';
$request = explode('/', $request);
$request = array_values(array_filter($request));

$data = [];

if(count($request) > 0) {
	if(isset($request[0]))
		$view = $request[0];

	$data = prepareArrayKeys($request);
} elseif (count($request) > 1) {
	$view = '404';
}

$path = (isset($view) && !empty($view)) ? $view : 'home';

if(file_exists(__dir__ . '/views/' . $path . '.blade.php')) {
	echo $blade->make($path, $data);
} else {
	echo $blade->make('404', $data);
}
