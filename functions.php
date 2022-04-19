<?php

if(!function_exists('pd')) {
	function pd($data = '') {
		dump($data);
	}
}

if(!function_exists('dd')) {
	function dd($data = '') {
		die(dump($data));
	}
}

if(!function_exists('getRestContents')) {
	function getRestContents($addr, $grace) {
		$grace = (!empty($grace)) ? $grace : 60 * 5;
		$json = false;
		$jsonFile = __dir__ . '/json/blockchain.json';

		$jsonAddr = 'https://blockchain.info/rawaddr/'. $addr . '?format=json';
		

		if((!file_exists($jsonFile) || filemtime($jsonFile) < time() - $grace)) {
			if (false !== ($contents = file_get_contents($jsonAddr))) {
				file_put_contents($jsonFile, $contents);
				$json = json_decode($contents, true);
			}
		}

		if($json === false && file_exists($jsonFile))
			$json = json_decode(file_get_contents($jsonFile), true);

		return $json;
	}
}


if(!function_exists('setAddrData')) {
	function setAddrData($addr, $grace) {
		$data = array();
		$jsonContent = getRestContents($addr, $grace);
        $total = (!empty($jsonContent['total_received'])) ? convertToBTCFromSatoshi($jsonContent['total_received']) : false;
        $count = (!empty($jsonContent['txs'])) ? count($jsonContent['txs']) : false;

		$data['main'] = [
			'total' => (!empty($total)) ? $total : false,
			'count' => (!empty($count)) ? $count : false
		];

        uasort($jsonContent['txs'], function($a, $b) {
            return $b['balance'] <=> $a['balance'];
        });

		if(!empty($jsonContent['txs'])) {
			foreach($jsonContent['txs'] as $index => $tx) {
				$mainIndex = $index;
				$balance = $tx['result'];

				if(!empty($tx['out'])) {
					foreach($tx['out'] as $index => $txOut) {
						if($txOut['spent'] === false && $txOut['value'] === 0) {
							if(!empty($txOut['script']))
								$opReturn = htmlentities(hex2bin(substr($txOut['script'], 4)));

							if(!empty($opReturn)) {
								$buildArray = array(
									'opReturn' => $opReturn,
									'balance' => $balance
								);
								$data['results'][$mainIndex] = $buildArray;
							}
						}
					}
				}
			}
		}
		
		if(!empty($data['results'])) {
			foreach($data['results'] as $index => $result) {
				if($index === array_key_first($data['results'])) {
					$data['results'][$index] += ['isFirst' => true];
				}
			}
		}

		return $data;
	}
}


if(!function_exists('convertToBTCFromSatoshi')) {
	function convertToBTCFromSatoshi($value) {
		$BTC = number_format(($value)*(pow(10, -8)), 8, '.', '');
		return $BTC;
	}
}

if(!function_exists('formatBTC')) {
	function formatBTC($value) {
		$value = sprintf('%.8f', $value);
		$value = rtrim($value, '0') . ' BTC';
		return $value;
	}
}

if(!function_exists('template')) {
	function template($path, $vars = [], $return = false) {
		$path = __dir__ . '/views/templates/' . $path . '.blade.php';

		if(!file_exists($path))
			return;

		extract($vars);

		if($return) {
			ob_start();
			include $path;
			$html .= ob_get_contents();
			ob_end_clean();

			return $html;
		}

		include $path;
	}
}

if(!function_exists('partial')) {
	function partial($path, $vars = [], $return = false) {
		return template('partials/' . $path, $vars, $return);
	}
}


if(!function_exists('prepareArrayKeys')) {
	function prepareArrayKeys($array) {
		$array = array_values($array);

		foreach($array as $k => $v) {
			unset($array[$k]);
			$key = 'arg_' . $k;
			$array[$key] = $v;
		}

		return $array;
	}
}


if(!function_exists('is_assoc')) {
	function is_assoc($arr) {
		if(!is_array($arr))
			return false;

		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}


if(!function_exists('getComponentPaths')) {
	function getComponentPaths($dir) {
		$files = list_files(__dir__ . '/views/' . $dir);
		$components = [];

		foreach(bootstrapFirst($files) as $file) {
			$file = explode($dir, $file);
			$file = array_values(array_filter(explode('/', $file[1])));

			$filename = (count($file) == 1) ? $file[0] : $file[count($file) - 1];
			$filename = explode('.blade',  $filename)[0];

			unset($file[count($file) - 1]);

			$path = implode('.', $file);

			$components[$filename] = str_replace('/', '.', $dir) . '.' . ($path != '' ? $path . '.' : $path) . $filename;
		}

		return $components;
	}
}

if(!function_exists('bootstrapFirst')) {
	function bootstrapFirst($array) {
		$first = [];
		$second = [];

		foreach($array as $path) {
			if(strpos($path, 'bootstrap/') !== false) {
				$first[] = $path;
			} else {
				$second[] = $path;
			}
		}

		return array_merge($first, $second);
	}
}


if(!function_exists('list_files')) {
	function list_files($base) {
		$files = $dirs = array();
		if(!is_dir($base)) return $files;

		if (($handle = opendir($base)) != false) {

			while (false !== ($file = readdir($handle))) {
				if ($file == "." || $file == ".." || $file == ".DS_Store") continue;

				if(is_dir("$base/$file")) {
					$dirs[] = "$base/$file";
				} else {
					$files[] = "$base/$file";
				}
			}
			closedir($handle);

			foreach ($dirs as $dir) {
				$subfiles = list_files($dir);
				$files = array_merge($files, $subfiles);
			}

		}

		return array_reverse($files);
	}
}


if(!function_exists('lorem')) {
	function lorem($paragraphs = 1, $headlingTags = false, $pTags = true) {
		$string = "";

		$strings = array(
			"Well, the way they make shows is, they make one show. That show's called a pilot. Then they show that show to the people who make shows, and on the strength of that one show they decide if they're going to make more shows. Some pilots get picked and become television programs. Some don't, become nothing. She starred in one of the ones that became nothing.",
			"My money's in that office, right? If she start giving me some bullshit about it ain't there, and we got to go someplace else and get it, I'm gonna shoot you in the head then and there. Then I'm gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I'm talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand?",
			"The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.",
			"Your bones don't break, mine do. That's clear. Your cells react to bacteria and viruses differently than mine. You don't get sick, I do. That's also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We're on the same curve, just on opposite ends.",
			"Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I'm in a transitional period so I don't wanna kill you, I wanna help you. But I can't give you this case, it don't belong to me. Besides, I've already been through too much shit this morning over this case to hand it over to your dumb ass.",
			"Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they're actually proud of that shit.",
			"You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don't know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I'm breaking now. We said we'd say it was the snow that killed the other two, but it wasn't. Nature is lethal but it doesn't hold a candle to man.",
			"Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a mechanical helicopter that shakes when you put quarters in it? No? Well, that's what you see at a toy store. And you must think you're in a toy store, because you're here shopping for an infant named Jeb.",
			"Now that we know who you are, I know who I am. I'm not a mistake! It all makes sense! In a comic, you know how you can tell who the arch-villain's going to be? He's the exact opposite of the hero. And most times they're friends, like you and me! I should've known way back when... You know why, David? Because of the kids. They called me Mr Glass.",
			"Look, just because I don't be givin' no man a foot massage don't make it right for Marsellus to throw Antwone into a glass motherfuckin' house, fuckin' up the way the nigger talks. Motherfucker do that shit to me, he better paralyze my ass, 'cause I'll kill the motherfucker, know what I'm sayin'?"
		);

		$headlines = array(
			"We happy?",
			"No man, I don't eat pork",
			"I gotta piss",
			"Hold on to your butts",
			"Uuummmm, this is a tasty burger!",
			"I'm serious as a heart attack",
			"Is she dead, yes or no?",
			"Are you ready for the truth?",
			"I can do that",
			"No, motherfucker"
		);

		for($i = 0; $i < $paragraphs; $i++) {
			$newString = $strings[rand(0, count($strings) - 1)];

			if($pTags) {
				$newString = "<p>" . $newString . "</p>";
			}

			if($headlingTags !== false) {
				$newString = "<" . $headlingTags . ">" . $headlines[rand(0, count($headlines) - 1)] . "</" . $headlingTags . ">" . $newString;
			}

			$string .= $newString;
		}

		echo trim($string);
	}
}


if(!function_exists('array_ran')) {
	function array_ran($array = [], $num = 1) {
		$keys = array_rand($array, $num);

		if(is_int($keys))
			$keys = [$keys];

		foreach($keys as $key) {
			echo $array[$key];
		}
	}
}