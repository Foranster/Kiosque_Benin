<?php
	function sampling($chars, $size, $combinations = array()) {
		if (empty($combinations)) {
			$combinations = $chars;
		}
		if ($size == 1) {
			return $combinations;
		}
		$new_combinations = array();
		foreach ($combinations as $combination) {
			foreach ($chars as $char) {
				$new_combinations[] = $combination . $char;
			}
		}
		return sampling($chars, $size - 1, $new_combinations);
	}
	$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$output = sampling($chars, 3);
	$fichier = file("dico.txt");
	$nombre = count($fichier);
	for($i = 0; $i < $nombre; $i++){
		for($x = 0; $x <= 9999; $x++){
			for($j = 0; $j < 17576; $j++){
				if(hash("sha256", trim($fichier[$i]).sprintf("%04d", $x).$output[$j]) == "d7b7c317f5ba2902ead0c49979f7b9665ea63b5dd12e873b812a670b169bbd86"){
					echo trim($fichier[$i]).sprintf("%04d", $x).$output[$j]; ?> <br> <?php
					break;
				}
			}
		}
	} 
