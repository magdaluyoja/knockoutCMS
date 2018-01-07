<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : "";
	if($action === "getSubjects"){
		echo public_navigation(false);
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
			$data = "{".'"id":"'.$row['id'].'", "submenu_name":"'.$row["menu_name"].'", "position":"'.$row["position"].'", "visible":"'.$row["visible"].'", "content":"'.addslashes(json_encode($row["content"])).'"}';
		}
		echo $data;
		exit();
	}
	if($action === "getSubjectContent"){
		$subjectId = $_POST["subjectId"];
		$query = "SELECT * FROM subjects WHERE id = '$subjectId'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		while ($row = mysqli_fetch_array($result))
		{
			$data =  $row['id'].','.$row["menu_name"].",".$row["position"].",".$row["visible"];
		}

		$query = "SELECT * FROM pages WHERE subject_id = '$subjectId'";
		$result = mysqli_query($connection, $query);
		if(!$result){
			die("Error description: " . mysqli_error($connection));
		}
		$pagedata = array();
		while ($row = mysqli_fetch_array($result))
		{
			$pagedata[] = $row["menu_name"];
		}

		$pageList = implode(",", $pagedata);


		echo trim(preg_replace('/\s\s+/', '', $data)) ."|". $pageList;
		exit();
	}