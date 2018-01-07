<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";
	if($action === "login"){
	  	// validations
	  	$required_fields = array("username", "password");
	  	validate_presences($required_fields);
	  
	  	if (empty($errors)) {
	    	// Attempt Login

			$username = $_POST["username"];
			$password = $_POST["password"];
			
			$found_admin = attempt_login($username, $password);

		    if ($found_admin) {
		      	// Success
				// Mark user as logged in
				$_SESSION["admin_id"] = $found_admin["id"];
				$_SESSION["username"] = $found_admin["username"];
		      	echo "successful";
		    } else {
		      	// Failure
		      	echo $_SESSION["message"] = "Username/password not found.";
		    }
		}
	}