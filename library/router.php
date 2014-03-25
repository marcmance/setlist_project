<?php
	
	$defined_routes = array (
		"login" => array(
			"index" => "",
			"login" => "",
			"logout" => ""
		),
		"user" => array(
			"index" => array(
				"artists" => ""
			),
			"edit" => "",
			"register" => "",
			"create" => ""
		),
		"setlist" => array(
			"index" => "",
		),
		"dashboard" => "user/edit",
		"register" => "user/register"
	);


	$defined_routes2 = array (

	);
	
	function routeRequest($route) {
		global $defined_routes;
	
		if($route == '') {
			//redirect to login page
			$route = "login";
		}
		$new_route = array(
			"controller" => "",
			"action" => "",
			"index" => null,
			"id" => "",
			"child" => "",
			"childId" => ""
		);
	
		$route_array = explode("/",$route);
		
		//check for valid controller
		if(array_key_exists($route_array[0], $defined_routes)) {
			//if it's an array, valid controller
			if(is_array($defined_routes[$route_array[0]])) {
				$controller_actions_array = $defined_routes[$route_array[0]];
				$new_route["controller"] = $route_array[0];
				
				//check if there's an action
				if(isset($route_array[1])) {
					//valid action
					if(array_key_exists($route_array[1], $controller_actions_array)) {
						$new_route["action"] = $route_array[1];
						$new_route["index"] = false;
					}
					//must be an ID
					else {

						$new_route["action"] = "index";
						$new_route["index"] = true;
						$new_route["id"] = $route_array[1];

						//check for secondary action
						if(isset($route_array[2]) && $route_array[2] != "") {
							$new_route['action'] = $route_array[2];
							if(isset($route_array[3])) {
								$new_route['childId'] = $route_array[3];
							}
						}
					}
				}
				else {
					$new_route["action"] = "index";
					$new_route["index"] = true;
					$new_route["id"] = null;
				}
				return $new_route;
			}
			//if not, it's a reroute
			else {
				return routeRequest($defined_routes[$route_array[0]]);
			}
		}
		else {
			//invalid controller
		}
	}
?>