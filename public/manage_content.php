<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";
	if($action === "getSubjects"){
		echo public_navigation(true);
		exit();
	}
	if($action === "getPageContent"){
		$id = $_POST["pageId"];
		$query = "SELECT * FROM pages WHERE id = '$id'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		while ($row = mysqli_fetch_array($result))
		{
			$data = "{".'"id":"'.$row['id'].'", "submenu_name":"'.$row["menu_name"].'", "content":"'.addslashes(json_encode($row["content"])).'"}';
		}
		echo $data;
		exit();
	}
	if($action === "getSubjectContent"){
		$subjectId = $_POST["subjectId"];

		$query = "SELECT * FROM pages WHERE subject_id = '$subjectId' 
					AND visible = 1 ORDER BY id LIMIT 1";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		$pagedata = array();
		$row = mysqli_fetch_array($result);
		echo json_encode($row);
		exit();
	}