<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";

	if($action === "deletePage"){
		$id = $_POST["id"];
		$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
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

	if($action === "editPage"){
		$id = $_POST["id"];
		$query = "SELECT * FROM pages WHERE id = '$id'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		while ($row = mysqli_fetch_array($result))
		{
			$data =  $row['id'].','.$row["subject_id"].",".$row["menu_name"].",".$row["position"].",".$row["visible"].",".nl2br($row["content"]);
		}
		echo trim(preg_replace('/\s\s+/', '', $data));
		exit();
	}
	if($action === "savePage"){

		$mode = $_POST["mode"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$submenu_name = mysql_prep($_POST["submenu_name"]);
		$content = mysql_prep($_POST["content"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];

		$required_fields = array("menu_name", "position", "visible","content");
		validate_presences($required_fields);

		$fields_with_max_lengths = array("submenu_name" => 30);
  		validate_max_lengths($fields_with_max_lengths);

  		
	  		if (empty($errors)) {
			    // Perform Create
			    if($mode === "Save"){
			    	$submenucount = selVal("COUNT(*)","pages", "menu_name = '".$_POST["submenu_name"]."'");
					if(!$submenucount){
					   	$query  = "INSERT INTO pages (";
					    $query .= "  subject_id, menu_name, position, visible, content";
					    $query .= ") VALUES (";
					    $query .= "  {$menu_name}, '{$submenu_name}', {$position}, {$visible}, '{$content}'";
					    $query .= ")";
					}else{
						echo "Submenu already exists.";
						exit();
					}
			    }else{
			    	$id = trim($_POST["id"]);
			    	$query  = "UPDATE pages SET ";
				    $query .= "subject_id = '{$menu_name}', ";
				    $query .= "menu_name = '{$submenu_name}', ";
				    $query .= "position = '{$position}', ";
				    $query .= "visible = '{$visible}', ";
				    $query .= "content = '{$content}' ";
				    $query .= "WHERE id = {$id} ";
				    $query .= "LIMIT 1";

			    }
			    $result = mysqli_query($connection, $query);

			    if ($result) {
			      	// Success
				    $last_id = $connection->insert_id;
			      	$subject_name = selVal("menu_name", "subjects", "id = " . $menu_name);
			      	if($mode === "Save"){
				      	echo "successful"."|{".'"id":"'.$last_id.'", "submenu_name":"'.$submenu_name.'", "position":"'.$position.'", "visible":"'.$visible.'", "content":"'.addslashes(json_encode($content)).'", "subject_id":"'.$menu_name.'", "subject_name":"'.$subject_name.'"}';
				    }else{
				    	echo "successful"."|{".'"id":"'.$id.'", "submenu_name":"'.$submenu_name.'", "position":"'.$position.'", "visible":"'.$visible.'", "content":"'.addslashes(json_encode($content)).'", "subject_id":"'.$menu_name.'", "subject_name":"'.$subject_name.'"}';
				    }
			    } else {
			      	// Failure
			      	echo $_SESSION["message"] = "Submenu creation failed.";
			    }
			}else
			{
				echo "$errors";
			}
		exit();
	}

	if($action === "getPositionPageList"){
		$query = "SELECT position FROM pages GROUP BY position";
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
			$Slist .= "-{".'"id":"'.$row["id"].'", "menu_name":"'.$row["menu_name"].'"}';
		}

		$query = "SELECT * FROM pages ORDER BY subject_id";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		$Plist = "";
		while ($row = mysqli_fetch_array($result))
		{
			$subject_name = selVal("menu_name", "subjects", "id = " . $row["subject_id"]);
			$Plist .= "-{".'"id":"'.$row["id"].'", "submenu_name":"'.$row["menu_name"].'", "position":"'.$row["position"].'", "visible":"'.$row["visible"].'", "content":"'.addslashes(json_encode($row["content"])).'", "subject_id":"'.$row["subject_id"].'", "subject_name":"'.$subject_name.'"}';
		}

		echo trim(preg_replace('/\s+/', ' ', $list))."|".trim(substr($Slist, 1))."|".trim(substr($Plist, 1));
		exit();
	}





	