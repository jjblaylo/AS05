<?php 
	session_start();
    if(!isset($_SESSION["tutor_id"]) && !isset($_SESSION["student_id"])){ // if "user" not set,
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
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$sessSubjectError = null;
		$sessDateError = null;
		$sessTimeError = null;
	
		
		// keep track post values
		$sessSubject = $_POST['session_subject'];
		$sessDate = $_POST['session_date'];
		$sessTime = $_POST['session_timeframe'];

		
		// validate input
		$valid = true;
		if (empty($sessSubject)) {
			$sessSubjectError = 'Please enter Subject';
			$valid = false;
		}
		if (empty($sessDate)) {
			$sessDateError = 'Please enter Date';
			$valid = false;
		}
		if (empty($sessTime)) {
			$sessTimeError = 'Please enter Timeframe';
			$valid = false;
		} 
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "UPDATE sessions  set session_subject = ?, session_date =?, session_timeframe = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($sessSubject,$sessDate,$sessTime,$id));
			Database::disconnect();
			header("Location: sessions.php?id=$tutorid");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM sessions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$sessSubject = $data['session_subject'];
		$sessDate = $data['session_date'];
		$sessTime = $data['session_timeframe'];
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
		    			<h3>Update Session</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update_sessions.php?id=<?php echo $id?>" method="post">
	    			    
					  <div class="control-group">
					    <label class="control-label">Tutor ID</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $tutorid;?>
						    </label>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($sessSubjectError)?'error':'';?>">
					    <label class="control-label">Session Subject</label>
					    <div class="controls">
					      	<input name="session_subject" type="text" placeholder="Ex:Math" value="<?php echo !empty($sessSubject)?$sessSubject:'';?>">
					      	<?php if (!empty($sessSubjectError)): ?>
					      		<span class="help-inline"><?php echo $sessSubjectError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($sessDateError)?'error':'';?>">
					    <label class="control-label">Session Date</label>
					    <div class="controls">
					      	<input name="session_date" type="text" placeholder="Ex:May 15, 2020" value="<?php echo !empty($sessDate)?$sessDate:'';?>">
					      	<?php if (!empty($sessDateError)): ?>
					      		<span class="help-inline"><?php echo $sessDateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($sessTimeError)?'error':'';?>">
					    <label class="control-label">Session Timeframe</label>
					    <div class="controls">
					      	<input name="session_timeframe" type="text" placeholder="Ex:12am-2pm" value="<?php echo !empty($sessTime)?$sessTime:'';?>">
					      	<?php if (!empty($sessTimeError)): ?>
					      		<span class="help-inline"><?php echo $sessTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						    <button type="submit" class="btn btn-success">Update</button>
						    <a class="btn" href="sessions.php?id=<?php echo $tutorid?>">Back</a>
					    </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>