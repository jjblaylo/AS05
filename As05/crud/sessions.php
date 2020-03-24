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
    			<h3>Sessions </h3>
    		</div>
			<div class="row">
				<p>
				    <?php 
				    if($tutorid != null){
				        echo '<a href="create_sessions.php" class="btn btn-success" >Create New Session</a>';
				    }
					?>
					<a href="tutors.php">Tutor List</a> 
				    <a href="students.php">Student List</a>
				</p>
				
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Tutor ID</th>
		                  <th>Student ID</th>
		                  <th>Subject</th>
		                  <th>Session Date</th>
		                  <th>Session Timeframe</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php
		                
					    require '../crud/database.php';
					    $pdo = Database::connect();
					    
					    if ($tutorid){
					          $sql = "SELECT * FROM sessions 
						      LEFT JOIN tutors ON tutors.id = sessions.sess_tutor_id 
						      LEFT JOIN student ON student.id = sessions.sess_student_id
						      WHERE tutors.id = $tutorid 
						      ORDER BY session_date ASC";
					    }
					    else{
						    $sql = "SELECT * FROM sessions 
				            LEFT JOIN tutors ON tutors.id = sessions.sess_tutor_id 
						    LEFT JOIN student ON student.id = sessions.sess_student_id
						    WHERE student.id = $studentid OR sessions.sess_student_id IS NULL
						    ORDER BY session_date ASC";
					    }
						    
	 				    foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['sess_tutor_id'] . '</td>';
							   	echo '<td>'. $row['sess_student_id'] . '</td>';
							   	echo '<td>'. $row['session_subject'] . '</td>';
							   	echo '<td>'. $row['session_date'] . '</td>';
							   	echo '<td>'. $row['session_timeframe'] . '</td>';
							   	echo '<td>';
							   	if($tutorid != null){
							   	    echo '<a class="btn" href="read_sessions.php?id='.$row[0].'">Read</a>';
							   	    echo '&nbsp;';
							   	    echo '<a class="btn btn-success" href="update_sessions.php?id='.$row[0].'">Update</a>';
							   	    echo '&nbsp;'; 
							   	    echo '<a class="btn btn-danger" href="delete_sessions.php?id='.$row[0].'">Delete</a>';
							   	}
							   	else{
							   	    echo '<a class="btn btn-success" href="reserve_sessions.php?id='.$row[0].'">Reserve</a>';
							   	    echo '&nbsp;'; 
							   	    echo '<a class="btn btn-danger" href="unreserve_sessions.php?id='.$row[0].'">Unreserve</a>';
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