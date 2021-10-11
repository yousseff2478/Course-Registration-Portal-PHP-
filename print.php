<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['matricno'])){

    }else{
        RedirectTo('index.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Course Form Printout</title>
</head>
<style type="text/css">
	body {
		font-family: Ariel;
	}
	table{
		border: 1px solid black;
	}
	tr {
		padding: 15px;
	}
	tbody tr td {
		padding: 5px;
	}
	.col-center {
		text-align: center;
	}
</style>
<body>
	<div class="container-fluid">
		<center>
			<table border="1">
			<thead style="padding: 0;">
				<tr>
					<th><img src="images/pic/school_logo.png" alt="School Logo" width="70px" height="80px"></th>
					<th colspan="2"><h2>THE POLYTECHNIC IBADAN</h2></th>
					<th><img src="images/pic/nacoss_logo.jpeg" alt="Department Logo" width="70px" height="80px">
				</tr>
			</thead>
			<?php
			if(isset($_GET['sid'])){
				$matric = $_GET['sid'];
				$session = $_GET['session'];
				$semester = $_GET['semester'];
				
                $sql = "SELECT * FROM vwprint WHERE matricno = '$matric' AND session = '$session' AND semester = '$semester' AND status = 'Submitted' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    while($rows = mysqli_fetch_array($query_result)){
                    	$matricno = $rows['matricno'];
                    	$fullname = $rows['surname']." ".$rows['othername'];
                    	$level = $rows['level'];
                    	$session_ = $rows['session'];
                    	$semester_ = $rows['semester'];
                    	$program = $rows['program'];
                    	$department = $rows['department'];
                    	$faculty = $rows['faculty'];
                    	$picture = $rows['image'];
                    }
                }
            }
            ?>
			<tbody>
				<tr>
					<td colspan="4" style="text-align: center; padding: 3px;">STUDENT'S INFORMATON</td>
				</tr>
				<tr>
					<td>Matric No: </td>
					<td colspan="3"><?php echo $matricno; ?></td>
					
				</tr>
				<tr>
					<td>Full Names:</td>
					<td colspan="3"><?php echo $fullname; ?></td>
				</tr>
				<tr>
					<td>Level:</td>
					<td colspan="2"><?php echo $level; ?></td>
					<td rowspan="5"><img src="images/profile_pic/<?php echo $picture; ?>" alt="Student Image" width="100px" height="100px"></td>
				</tr>
				<tr>
					<td>Program:</td>
					<td colspan="2"><?php echo $program; ?></td>
				</tr>
				<tr>
					<td>Session/Semester:</td>
					<td colspan="2"><?php echo $session_ ."   ". $semester_; ?></td>
				</tr>
				<tr>
					<td>Department:</td>
					<td colspan="2"><?php echo $department; ?></td>
				</tr>
				<tr>
					<td>Faculty:</td>
					<td colspan="2"><?php echo $faculty; ?></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align: center; padding: 5px;">LIST OF REGISTERED COURSES</td>
				</tr>
				<tr>
					<th>Code</th>
					<th>Title</th>
					<th>Unit</th>
					<th>Nature</th>
				</tr>
				<?php
					if(isset($_GET['sid'])){
						$matric = $_GET['sid'];
						$session = $_GET['session'];
						$semester = $_GET['semester'];
		                $sql = "SELECT * FROM vwprint WHERE matricno = '$matric' AND session = '$session' AND semester = '$semester' AND status = 'Submitted'";
		                $query_result = mysqli_query($conn, $sql);
		                $result = mysqli_num_rows($query_result);
		                if($result > 0){
		                	while($data = mysqli_fetch_array($query_result)) {
		                ?>
		                	<tr>
						        <td><?php echo $data['course_code']; ?></td>
						        <td><?php echo $data['title']; ?></td>
						        <td class="col-center"><?php echo $data['unit']; ?></td>
						        <td><?php echo $data['grade']; ?></td>
						    </tr>
		                <?php
		                	}
		                }
		            }
		        ?>
			    <tr>
			        <td colspan="3" style="text-align: right;">Total Unit registered</td>
			        <td>
			        	<strong>
			        		<?php
			        			if(isset($_GET['sid'])){
			        				$session = $_GET['session'];
									$semester = $_GET['semester'];
			        				$course_count = 0;
                                    $sql = "SELECT SUM(unit) FROM vwprint WHERE level = '{$_SESSION['level']}' AND program = '{$_SESSION['program']}' AND department = '{$_SESSION['department']}' AND session = '$session' AND semester = '$semester' AND matricno = '{$_SESSION['matricno']}' ";
                                    $query_result = mysqli_query($conn, $sql);
                                    $result = mysqli_num_rows($query_result);
                                        while ($row = mysqli_fetch_array($query_result)) {
                                            $course_count += $row['SUM(unit)'];
                                        }
                                        echo $course_count;
			        			}
			        		?>
			        	</strong>
			    	</td>
			    </tr>
			    <tr style="text-align: center; font-weight: normal; margin: 15px; ">
			        <td colspan="15" colspacing="5">__________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________<br>
			        	<small>STUDENT SIGNATURE</small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COORDINATOR SIGNATURE</small>
			    </tr>
			    <?php
			    		
			    ?>
			</tbody>		
		</table></center>
	</div>
	
</body>
</html>