<?php
	include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');
	
	/*function getTotalCourseUnit($session, $semester, $level, $program, $department){
		$count = 0;
		$sql = "SELECT SUM(unit) FROM tbl_added_courses WHERE level = '$level' AND program = '$program' AND department = '$department' AND session = '$session' AND semester = '$semester' ";
        $query_result = mysqli_query($conn, $sql);
        $result = mysqli_num_rows($query_result);
        while($row = mysqli_fetch_assoc($query_result)){
        	$count += $row['unit'];
        }
        return $count;
	}

	$sql = "SELECT SUM(unit) FROM tbl_added_courses WHERE level = '{$_SESSION['level']}' AND program = '{$_SESSION['program']}' AND department = '{$_SESSION['department']}' AND session = '{$_SESSION['ses']}' AND semester = '{$_SESSION['sem']}' ";
                                                        $query_result = mysqli_query($conn, $sql);
                                                        $result = mysqli_num_rows($query_result);
                                                        while($row = mysqli_fetch_assoc($query_result)){
                                                            $count += $row['unit'];
                                                        }
                                                        echo $count;*/

                                                        SELECT sub.session,sub.semester,sub.matricno,sub.status,stu.surname,stu.othername,stu.level,stu.program,stu.faculty,stu.department,stu.image FROM tbl_submitted_courses AS sub INNER JOIN tblstudent AS stu ON sub.matricno = stu.matricno WHERE sub.session = '2021-2022' AND sub.semester = 'First Semester' AND sub.matricno = '2017070510126' AND sub.status='Submitted'



                                                        SELECT sub.session,sub.semester,sub.matricno,sub.status,stu.surname,stu.othername,stu.level,stu.program,stu.faculty,stu.department,stu.image,sub.course_code,sub.title,sub.unit,sub.grade FROM tbl_submitted_courses AS sub INNER JOIN tblstudent AS stu ON sub.matricno = stu.matricno WHERE sub.session = '2021-2022' AND sub.semester = 'First Semester' AND sub.matricno = '2017070510126' AND sub.status='Submitted'

?>