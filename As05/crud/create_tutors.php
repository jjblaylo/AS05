<?php 
	session_start();
    if(!isset($_SESSION["tutor_id"]) && !isset($_SESSION["student_id"])){
	    session_destroy();
	    header('Location: homepage.php');   
	    exit;
    }

        
	require '../crud/database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$fnameError = null;
		$lnameError = null;
		$emailError = null;
		$tsubjectError = null;
		$passError = null;
		
		// keep track post values
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$tsubject  = $_POST['tsubject'];
		$pass  = $_POST['pass'];
		$passHash = MD5($pass);
		
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
		
		
		if (empty($tsubject)) {
			$tsubjectError = 'Please enter Tutoring Subject';
			$valid = false;
		}
		
		if (empty($pass)) {
			$passError = 'Please enter Password';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO tutors (fname,lname,email,tutoring_subject,password) values(?, ?, ?,?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($fname,$lname,$email,$tsubject,$passHash));
			Database::disconnect();
			header("Location: login_tutors.php");
		}
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
		    			<h3>Create a Tutor</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create_tutors.php" method="post">
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
					      	<input name="lname" type="text"  placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
					      	<?php if (!empty($lnameError)): ?>
					      		<span class="help-inline"><?php echo $lnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($tsubjectError)?'error':'';?>">
					    <label class="control-label">Tutoring Subject</label>
					    <div class="controls">
					      	<input name="tsubject" type="text"  placeholder="Tutoring Subject" value="<?php echo !empty($tsubject)?$tsubject:'';?>">
					      	<?php if (!empty($tsubjectError)): ?>
					      		<span class="help-inline"><?php echo $tsubjectError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					   <div class="control-group <?php echo !empty($passError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="pass" type="text"  placeholder="Password not SVSU password" value="<?php echo !empty($pass)?$pass:'';?>">
					      	<?php if (!empty($passError)): ?>
					      		<span class="help-inline"><?php echo $passError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="login_tutors.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>