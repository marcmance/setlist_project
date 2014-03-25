<?php

$directoryName = 'requests/';

ini_set('display_errors', 'On');

foreach (new DirectoryIterator($directoryName) as $file) {
   // if the file is not this file
   if ( (!$file->isDot()) && ($file->getFilename() != basename($_SERVER['PHP_SELF'])) ) {
		ini_set("auto_detect_line_endings", true);
		$fileName = $directoryName . $file->getFilename();

		$lines = file($fileName);
		$invalidStatement = "";
		
		
		//read each line
		foreach ($lines as $line_num => $line) {
				
			//echo $line_num . " : " . $line . " |||||| " . $invalidStatement . "</br>";	
			
			//check for blank line and then break 
			if(strlen($line) == 2) {
				break;
			}
			if($line_num == 0) {
				$lines_split = explode(" ", $line);
				//check for POST or GET
				if($lines_split[0] != "POST" && $lines_split[0] != "GET") {
					$invalidStatement .= "<b>Not a valid method: ". $lines_split[0] ."</b></br> ";
					//echo "1: " . $invalidStatement . "</br>";
				} 
				//check for valid path
				if(!preg_match('^(?!-)[a-z0-9-]+(?<!-)(/(?!-)[a-z0-9-]+(?<!-))*$^',$lines_split[1])) {
				//if(!preg_match('/^[^*?"<>|:]*$/',$lines_split[1])) {
					$invalidStatement .= "<b>Not a valid path". $lines_split[1] ."</b></br> ";
					//echo "2: " . $invalidStatement . "</br>";
				} 
				
				//check for valid verison
				if(trim($lines_split[2]) != "HTTP/1.1") {
					$invalidStatement .= "<b>Not a valid version: ". $lines_split[2] ."</b></br> ";
					//echo "3: " . $invalidStatement . "</br>";
				}
			}
			
			else {
				$lines_split = explode(":", $line);
				//echo "--- " . strlen($line) . "</br>";
				//echo "<b>".$lines_split[0]."</b> |||| <b>" . $lines_split[1] . "</b></br>";
				
				if($lines_split[0] != "Accept" && $lines_split[0] != "Host" && $lines_split[0] != "Referer") {
					$invalidStatement .= "<b>Not a valid header name: ". $lines_split[0] ."</b></br> ";
				}
				
				if(strlen($lines_split[1]) < 1) {
					$invalidStatement .= "<b>Not a valid value.</b></br> ";
				}
			} 
		
			//echo "END: " . $invalidStatement . "</br>";
		}

		if(strlen($invalidStatement) > 0) {
			echo "<B>File Name: </b>". $file->getFilename() . "</br>";
			echo $invalidStatement;
		}
		else {
			echo "<b>". $file->getFilename() . " is valid</b></br>";
		}

		echo "</br>";
	}
}

?>