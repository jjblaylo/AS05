<?php 
	
	require '../crud/database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: students.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$fnameError = null;
		$lnameError = null;
		$emailError = null;
		$yearError = null;
		
		// keep track post values
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$year = $_POST['year'];
		
		// validate input
		$valid = true;
		if (empty($fname)) {
			$fnameError = 'Please enter First Name';
			$valid = false;
		}
		
		if (empty($lname)) {
			$lnameError = 'Please enter Last Name';
			$valid = false;
		} 
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		}
		
		if (empty($year)) {
			$yearError = 'Please enter Year ';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE student  set fname = ?, lname = ?, email =?, year = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($fname,$lname,$email,$year,$id));
			Database::disconnect();
			header("Location: students.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM student where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$fname = $data['fname'];
		$lname = $data['lname'];
		$email = $data['email'];
		$year = $data['year'];
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
		    			<h3>Update a Student</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update_students.php?id=<?php echo $id?>" method="post">
	    			    
					  <div class="control-group <?php echo !empty($fnameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="fname" type="text"  placeholder="First Name" value="<?php echo !empty($fname)?$fname:'';?>">
					      	<?php if (!empty($fnameError)): ?>
					      		<span class="help-inline"><?php echo $fnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($lnameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="lname" type="text" placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
					      	<?php if (!empty($lnameError)): ?>
					      		<span class="help-inline"><?php echo $lnameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text"  placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailnError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($yearError)?'error':'';?>">
					    <label class="control-label">Year</label>
					    <div class="controls">
					      	<input name="year" type="text"  placeholder="Year" value="<?php echo !empty($year)?$year:'';?>">
					      	<?php if (!empty($yearError)): ?>
					      		<span class="help-inline"><?php echo $yearError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="students.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>