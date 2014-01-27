<?php


		$directory = new \RecursiveDirectoryIterator('src/TUM/Ventureinitiative/TestBundle/Wizard/Tests/');
		$iterator = new \RecursiveIteratorIterator($directory);
		$regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
		
		foreach($regex as $item) {
		
			
				var_dump(strtr(substr($item[0], strpos($item[0], 'TUM'), -4), "/", "\\"));
			
				var_dump($item);
		
		
		}
