<?php 
    session_start();
    if(!isset($_SESSION["tutor_id"]) && !isset($_SESSION["student_id"])){ // if "user" not set,
	    session_destroy();
	    header('Location: homepage.php');   
	    exit;
    }
    
    $studentid = null;
    
	require '../crud/database.php';
	
	$sessionid = $_REQUEST['id'];
	
	
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "UPDATE sessions  set sess_student_id = ? where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($studentid,$sessionid));
	Database::disconnect();
	header("Location: sessions.php");
?>
