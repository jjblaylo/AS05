<?php
    session_start();
    if(!isset($_SESSION["tutor_id"]) && !isset($_SESSION["student_id"])){
	    session_destroy();
	    header('Location: homepage.php');   
	    exit;
    }
        
        $studentid = $_SESSION['student_id'];
        $tutorid = $_SESSION['tutor_id'];
    
    
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
    		<div class="row">
    			<h3>Students</h3>
    		</div>
			<div class="row">
				<p>
				   
				    <a href="sessions.php">Session List</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>First Name</th>
		                  <th>Last Name</th>
		                  <th>Email</th>
		                  <th>Year</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   require '../crud/database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM student ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['fname'] . '</td>';
							   	echo '<td>'. $row['lname'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['year'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read_students.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	if($row['id'] == $studentid){
							   	    echo '<a class="btn btn-success" href="update_students.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete_students.php?id='.$row['id'].'">Delete</a>';
							   	}
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>