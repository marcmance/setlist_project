<?php
	function printArray($arr) {
		echo "<br/>";
		echo '<div style="background-color:#E3DCDE;border:1px solid black;">';
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		echo "</div>";
	}

	function echoPretty($string = null) {
		if($string == null) {
			$string = "";
		}
		echo "<br/>";
		echo '<div style="background-color:#E3DCDE;border:1px solid black;">';
		echo '<b>You echoed:</b><br/>';
		echo $string;
		echo "</div>";
	} 
	
	function dateParser($date) {
		//format YYYY-MM-DD
		$dateExploded = explode("-",$date);
		switch ($dateExploded[1]) {
			case "01":
				$dateExploded[1] = "Jan";
				break;
			case "02":
				$dateExploded[1] = "Feb";
				break;
			case "03":
				$dateExploded[1] = "Mar";
				break;
			case "04":
				$dateExploded[1] = "Apr";
				break;
			case "05":
				$dateExploded[1] = "May";
				break;
			case "06":
				$dateExploded[1] = "Jun";
				break;
			case "07":
				$dateExploded[1] = "Jul";
				break;
			case "08":
				$dateExploded[1] = "Aug";
				break;
			case "09":
				$dateExploded[1] = "Sep";
				break;
			case "10":
				$dateExploded[1] = "Oct";
				break;
			case "11":
				$dateExploded[1] = "Nov";
				break;
			case "12":
				$dateExploded[1] = "Dec";
				break;
		}

		return $dateExploded;
	}

	function formatDate($date) {
		date_default_timezone_set('America/New_York');
		$date_formatted = new DateTime($date);
		return $date_formatted->format('F jS, Y');
	}

	function getOrdinal($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if (($number %100) >= 11 && ($number%100) <= 13) {
			return $number. 'th';
		}
		else {
			return $number. $ends[$number % 10];
		}
		   
	}

	function isSingleRecord($result) {
		if(isset($result['singleRecord'])) {
			return true;
		}
		return false;
	}

	function toLowerCaseAndTrim($string) {
		return strtolower(str_replace(' ', '', $string));
	}
?>