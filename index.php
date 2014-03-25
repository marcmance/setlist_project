<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors',1); 
	$start = microtime(true);
	if(file_exists("library/shared.php")) {
		require_once "library/shared.php";
		require_once "library/router.php";
	}
	
	$route = $_GET['p'];

	$route_array = routeRequest($route);

	$controller_name = $route_array["controller"] . "Controller";
	$con = new $controller_name();
	
	$page_to_load = "";
	$page_to_load_wo_php = "";
	
	if(!$route_array["index"]) {
		call_user_func(array($con,$route_array["action"]));
		$page_to_load_wo_php = $route_array["controller"] . "/" . $route_array["action"];
		$page_to_load = $page_to_load_wo_php . ".php";
	}
	else {
		if(isset($route_array["id"])) {
			//$page_to_load = $route_array["controller"] . $route_array["action"] . ".php?id=" . $route_array["id"];
			$page_to_load = $route_array["controller"] . "/" . $route_array["action"] . ".php";
			$page_to_load_wo_php = $route_array["controller"] . "/" . $route_array["action"];
			
			$con->urlParams['id'] = $route_array["id"];
		}
		else {
			$page_to_load = $route_array["controller"] . "/". $route_array["action"] . ".php";
			$page_to_load_wo_php = $route_array["controller"] ."/" . $route_array["action"];
		}

		if(isset($route_array["childId"]) && $route_array["childId"] != "") {
			$con->urlParams['childId'] = $route_array["childId"];
		}
		call_user_func(array($con,$route_array["action"]));
	}	
	//echo "<br/><br/>Route request = [" . $route . "]<br/>";
	
	//echoPretty($page_to_load);

	function __autoload($className) {
		//autoload controller
		if(file_exists("controllers/". $className . ".php")) {
			require_once "controllers/". $className . ".php";
		}
		//autoload model
		else if(file_exists("models/". $className . ".php")) {
			require_once "models/". $className . ".php";
		}
	}
?>

<html>
	<head>
		<title><?php echo $con->pageTitle; ?></title>
		<script src="/js/jquery-1.8.0.min.js"></script>
		<script src="/js/helper_functions.js"></script>
		<script src="/js/main.js"></script>
		<link href="/css/main.css" type="text/css" rel="stylesheet" />

		
		<?php
			if(file_exists("js/". $page_to_load_wo_php . ".js")) {
				?>
				<script src="/js/<?php echo $page_to_load_wo_php ?>.js"></script>
				<?php
			}
		?>
	</head>
	<body>
		<?php include "/header2.php"; ?>
		<br/>
		<div id="mainContainer">
			<div id="pageContainer">
				<?php include "views/".$page_to_load; ?>
			</div>
		</div>
	</body>
</html>

<?php
$end = microtime(true);
print "Page generated in ".round(($end - $start), 4)." seconds";
?>