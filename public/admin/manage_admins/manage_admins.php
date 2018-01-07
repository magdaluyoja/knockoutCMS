<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";

	
	if($action === "editAdmin"){
		$id = $_POST["id"];
		$query = "SELECT id,username FROM admins WHERE id = '$id'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		while ($row = mysqli_fetch_array($result))
		{
			echo $row['id'].','.$row["username"];
		}
		exit();
	}

	if($action === "deleteAdmin"){
		$id = $_POST["id"];
		$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
	  	$result = mysqli_query($connection, $query);

	  	if ($result && mysqli_affected_rows($connection) == 1) {
	    	// Success
	    	echo "successful";
	  	} else {
	   	 	// Failure
	    	echo $_SESSION["message"] = "Admin deletion failed.";
	  	}
	  	exit();
	}

	if($action === "getAdminList"){
		$userList = "";
		$query = "SELECT id,username FROM admins";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}else{
			while ($row = mysqli_fetch_array($result))
			{
				$userList .=  "|{".'"username":"'.$row['username'].'", "id":"'.$row["id"].'"}';
			}
			echo substr($userList, 1);
		}
		exit();
	}

	if($action === "saveAdmin"){
		$mode = $_POST["mode"];
		$required_fields = array("username", "password", "confirmpassword");
		validate_presences($required_fields);

		$fields_with_max_lengths = array("username" => 30);
  		validate_max_lengths($fields_with_max_lengths);

  		if (empty($errors)) {
		    // Perform Create
		    $username = mysql_prep($_POST["username"]);
		    $hashed_password = password_encrypt($_POST["password"]);
		    if($mode === "Save"){
		    	$usercount = selVal("COUNT(*)","admins", "username = '".$_POST["username"]."'");
		    	if(!$usercount){
				    $query  = "INSERT INTO admins (";
				    $query .= "  username, hashed_password";
				    $query .= ") VALUES (";
				    $query .= "  '{$username}', '{$hashed_password}'";
				    $query .= ")";
				}else{
					echo "User already exists.";
					exit();
				}
		    }else{
		    	
			    	$id = $_POST["id"];
			    	$query  = "UPDATE admins SET ";
				    $query .= "username = '{$username}', ";
				    $query .= "hashed_password = '{$hashed_password}' ";
				    $query .= "WHERE id = {$id} ";
				    $query .= "LIMIT 1";
		    }
		    $result = mysqli_query($connection, $query);

		    if ($result) {
		      	// Success
		      	if($mode === "Save"){
			      	$last_id = $connection->insert_id;
			      	echo "successful"."|{".'"username":"'.$username.'", "id":"'.$last_id.'"}';
			    }else{
			    	echo "successful"."|{".'"username":"'.$username.'", "id":"'.trim($id).'"}';
			    }
		    } else {
		      	// Failure
		      	echo $_SESSION["message"] = "Admin creation failed.";
		    }
		}else
		{
			echo "$errors";
		}
		
		exit();
	}




	