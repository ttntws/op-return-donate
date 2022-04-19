<?php

	$filesCache = glob(__dir__ . '/cache/*');
	$filesJson = glob(__dir__ . '/json/*');

	foreach($filesCache as $file){
		if(is_file($file))
			unlink($file);
	}

	foreach($filesJson as $file){
		if(is_file($file))
			unlink($file);
	}