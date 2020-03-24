<?php 
    session_start();
    if(!isset($_SESSION["tutor_id"])){ // if "user" not set,
	    session_destroy();
	    header('Location: homepage.php');   
	    exit;
    }
    
    $tutorid = $_SESSION["tutor_id"];
    
	require '../crud/database.php';
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: sessions.php?id=$tutorid");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM sessions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
	
		$sql = "SELECT * FROM tutors where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($data['sess_tutor_id']));
        $tutdata = $q->fetch(PDO::FETCH_ASSOC);
        
        $studentId = $data['sess_student_id'];
		if($data['sess_student_id'] != null){
		    $sql = "SELECT * FROM student where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($data['sess_student_id']));
            $studdata = $q->fetch(PDO::FETCH_ASSOC);
		}
		
		
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Session Info</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Tutor Id:</label>
					    <div class="controls">
						    <label class="checkbox">
							    <?php echo $tutdata['fname']." ". $tutdata['lname'] ;?>
						    </label>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">Student Id:</label>
					    <div class="controls">
					      	<label class="checkbox">
						    	<?php 
						    	    if($studentId ==null){
						    	        echo  $studentId;
						    	    }
						    	    else{
						    	        echo $studdata['fname']." ". $studdata['lname'] ;
						    	    }
						    	?>
						    </label>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">Session Subject:</label>
					    <div class="controls">
					      	<label class="checkbox">
							    <?php echo $data['session_subject'] ;?>
					    	</label>
					    </div>
					    
					    <div class="control-group">
					    <label class="control-label">Session Date:</label>
					    <div class="controls">
					      	<label class="checkbox">
							    <?php echo $data['session_date'] ;?>
					    	</label>
					    </div>
					    
					    <div class="control-group">
					    <label class="control-label">Session Timeframe:</label>
					    <div class="controls">
					      	<label class="checkbox">
							    <?php echo $data['session_timeframe'] ;?>
					    	</label>
					    </div>

					    <div class="form-actions">
						  <a class="btn" href="sessions.php?id=<?php echo $tutorid?>">Back</a>
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>