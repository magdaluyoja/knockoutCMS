<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";

	if($action === "deleteSubject"){
		$id = $_POST["id"];
		$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	  	$result = mysqli_query($connection, $query);

	  	if ($result && mysqli_affected_rows($connection) == 1) {
	    	// Success
	    	echo "successful";
	  	} else {
	   	 	// Failure
	    	echo $_SESSION["message"] = "Menu deletion failed.";
	  	}
		exit();
	}

	if($action === "editSubject"){
		$id = $_POST["id"];
		$query = "SELECT * FROM subjects WHERE id = '$id'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		while ($row = mysqli_fetch_array($result))
		{
			$data =  $row['id'].','.$row["menu_name"].",".$row["position"].",".$row["visible"];
		}
		echo trim(preg_replace('/\s\s+/', '', $data));
		exit();
	}
	if($action === "saveSubject"){

		$mode = $_POST["mode"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];

		$required_fields = array("menu_name", "position", "visible");
		validate_presences($required_fields);

		$fields_with_max_lengths = array("menu_name" => 30);
  		validate_max_lengths($fields_with_max_lengths);

  		
	  		if (empty($errors)) {
			    // Perform Create
			    if($mode === "Save"){
			    	$menucount = selVal("COUNT(*)","subjects", "menu_name = '".$_POST["menu_name"]."'");
					if(!$menucount){
					    $query  = "INSERT INTO subjects (";
						$query .= "  menu_name, position, visible";
						$query .= ") VALUES (";
						$query .= "  '{$menu_name}', {$position}, {$visible}";
						$query .= ")";
					}else{
						echo "Menu already exists.";
						exit();
					}
			    }else{
			    	$id = trim($_POST["id"]);
			    	$query  = "UPDATE subjects SET ";
				    $query .= "menu_name = '{$menu_name}', ";
				    $query .= "position = '{$position}', ";
				    $query .= "visible = '{$visible}' ";
				    $query .= "WHERE id = {$id} ";
				    $query .= "LIMIT 1";
			    }
			    $result = mysqli_query($connection, $query);

			    if ($result) {
			      	// Success
			      	if($mode === "Save"){
				      	$last_id = $connection->insert_id;
				      	echo "successful"."|{".'"id":"'.$last_id.'", "menu_name":"'.$menu_name.'", "position":"'.$position.'", "visible":"'.$visible.'"}';
				    }else{
				    	echo "successful"."|{".'"id":"'.$id.'", "menu_name":"'.$menu_name.'", "position":"'.$position.'", "visible":"'.$visible.'"}';
				    }
			    } else {
			      	// Failure
			      	echo $_SESSION["message"] = "Menu creation failed.";
			    }
			}else
			{
				echo "$errors";
			}
		exit();
	}

	if($action === "getPositionSubjectList"){
		$query = "SELECT position FROM subjects GROUP BY position";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		$list = "";
		while ($row = mysqli_fetch_array($result))
		{
			$list .= ','.$row["position"];
			$lastno = $row["position"];
		}
		$list = $list.",".($lastno+1);

		$query = "SELECT * FROM subjects";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		$Slist = "";
		while ($row = mysqli_fetch_array($result))
		{
			$Slist .= "-{".'"id":"'.$row["id"].'", "menu_name":"'.$row["menu_name"].'", "position":"'.$row["position"].'", "visible":"'.$row["visible"].'"}';
		}

		echo preg_replace( "/\r|\n/", "", $list )."|".trim(substr($Slist, 1));
		exit();
	}





	