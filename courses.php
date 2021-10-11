<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['matricno'])){
        $sql = "SELECT * FROM tblsemester WHERE status = 'Open' ";
        $query_result = mysqli_query($conn, $sql);
        $result = mysqli_num_rows($query_result);
        if($result > 0){
            while($rows = mysqli_fetch_assoc($query_result)){
                $_SESSION['sem'] = $rows['semester'];
                $session = $rows['session_from']."-".$rows['session_to'];
                $_SESSION['ses'] = $session;
            }
        }else{
            $_SESSION['sem'] = "";
            $_SESSION['ses'] = "";
        }

        if(isset($_POST['btn_add_course'])){
            $c_code = $_POST['c_code'];
            $c_title = $_POST['c_title'];
            $c_unit = $_POST['c_unit'];
            $c_grade = $_POST['c_grade'];
            $c_session = $_POST['c_session'];
            $c_semester = $_POST['c_semester'];
            $stu_matricno = $_POST['stu_matricno'];
            $stu_level = $_POST['stu_level'];

            $c_code = mysqli_real_escape_string($conn, $c_code);
            $c_title = mysqli_real_escape_string($conn, $c_title);
            $c_unit = mysqli_real_escape_string($conn, $c_unit);
            $c_grade = mysqli_real_escape_string($conn, $c_grade);
            $c_session = mysqli_real_escape_string($conn, $c_session);
            $c_semester = mysqli_real_escape_string($conn, $c_semester);
            $stu_matricno = mysqli_real_escape_string($conn, $stu_matricno);
            $stu_level = mysqli_real_escape_string($conn, $stu_level);

            $sql2 = "SELECT * FROM tbl_submitted_courses WHERE course_code='$c_code' AND session='$c_session' AND semester='$c_semester' AND matricno='$stu_matricno' AND level='$stu_level'  ";
            $query_result2 = mysqli_query($conn, $sql2);
            $result2 = mysqli_num_rows($query_result2);
            if($result2 > 0){
                $_SESSION['ErrorMessage'] = $c_code . " has been submitted already";
            }else{
                $sql3 = "INSERT INTO tbl_submitted_courses (course_code,title,unit,grade,session,semester,matricno,level) VALUES('$c_code','$c_title','$c_unit','$c_grade','$c_session','$c_semester','$stu_matricno','$stu_level') ";
                $query_result3 = mysqli_query($conn, $sql3);

                if($query_result3){
                    $_SESSION['SuccessMessage'] = $c_code . " has been added successfully";
                }else{
                    $_SESSION['ErrorMessage'] = "Failed to add course";
                }
            }
        }elseif(isset($_POST['btn_remove_course'])){
            $c_code2 = $_POST['c_code2'];
            $c_session2 = $_POST['c_session2'];
            $c_semester2 = $_POST['c_semester2'];
            $stu_matricno2 = $_POST['stu_matricno2'];
            $stu_level2 = $_POST['stu_level2'];

            $c_code2 = mysqli_real_escape_string($conn, $c_code2);
            $c_session2 = mysqli_real_escape_string($conn, $c_session2);
            $c_semester2 = mysqli_real_escape_string($conn, $c_semester2);
            $stu_matricno2 = mysqli_real_escape_string($conn, $stu_matricno2);
            $stu_level2 = mysqli_real_escape_string($conn, $stu_level2);

            $sql = "DELETE FROM tbl_submitted_courses WHERE course_code='$c_code2' AND session='$c_session2' AND semester='$c_semester2' AND matricno='$stu_matricno2' AND level='$stu_level2' ";
            $query_result = mysqli_query($conn, $sql);

            if($query_result){
                $_SESSION['SuccessMessage'] = $c_code2 . " has been removed successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to remove " . $c_code;
            }
        }elseif(isset($_POST['btn_final_submit'])){

            $sql = "UPDATE tbl_submitted_courses SET status='Submitted' WHERE session='{$_SESSION['ses']}' AND semester='{$_SESSION['sem']}' AND matricno='{$_SESSION['matricno']}' AND level='{$_SESSION['level']}' ";
            $query_result = mysqli_query($conn, $sql);

            if($query_result){
                $_SESSION['SuccessMessage'] = "Course has been submitted successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to submit course";
            }
        }

    }else{
        RedirectTo('index.php');
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include_once('includes/styles.html') ?>
</head>

<body>
    <?php include_once('includes/nav.php') ?>
    <section class="container-wrap">
        <div class="container wrap">
            <div class="row">
                <div class="col-md-4 col">
                   <?php include_once('includes/leftside.php') ?>
                </div>

                <div class="col-md-8 col">
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?> 
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <?php
                            $sql = "SELECT * FROM tblsemester WHERE status = 'Open' ";
                            $query_result = mysqli_query($conn, $sql);
                            $result = mysqli_num_rows($query_result);
                            if($result > 0){
                                while($row = mysqli_fetch_assoc($query_result)){
                                    $sem = $row['semester'];
                                    $ses_from = $row['session_from'];
                                    $ses_to = $row['session_to'];
                                }
                            }else{
                                while($row = mysqli_fetch_assoc($query_result)){
                                    $sem = "";
                                    $ses_from = "";
                                    $ses_to = "";
                                }
                            }

                            ?>
                            <?php if($result): ?>
                                <h4>List of courses for this semester and session <small><strong><span style="color: black;" class="pull-right"><?php echo $sem; ?> / <?php echo $ses_from; ?>-<?php echo $ses_to; ?></span></strong></small></h4>
                            <?php else: ?>
                                <h4>List of courses for this semester and session <small><strong><span style="color: black;" class="pull-right">No Semester/Session Set</span></strong></small></h4>
                            <?php endif; ?>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Course Code </th>
                                                <th>Course Title</th>
                                                <th>Course Unit </th>
                                                <th>Status </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbl_added_courses WHERE department = '{$_SESSION['department']}' AND level = '{$_SESSION['level']}' AND program = '{$_SESSION['program']}' AND semester = '{$_SESSION['sem']}' AND session = '{$_SESSION['ses']}' ORDER BY course_code ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                                if($result > 0){
                                                    while($row = mysqli_fetch_array($query_result)){
                                                        $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['course_code']; ?></td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['unit']; ?></td>
                                                <td><?php echo $row['grade']; ?></td>
                                                <td>
                                                    <form action="courses.php" method="POST">
                                                        <input type="hidden" name="c_code" value="<?php echo $row['course_code']; ?>">
                                                        <input type="hidden" name="c_title" value="<?php echo $row['title']; ?>">
                                                        <input type="hidden" name="c_unit" value="<?php echo $row['unit']; ?>">
                                                        <input type="hidden" name="c_grade" value="<?php echo $row['grade']; ?>">
                                                        <input type="hidden" name="c_session" value="<?php echo $_SESSION['ses']; ?>">
                                                        <input type="hidden" name="c_semester" value="<?php echo $_SESSION['sem']; ?>">
                                                        <input type="hidden" name="stu_matricno" value="<?php echo $_SESSION['matricno']; ?>">
                                                        <input type="hidden" name="stu_level" value="<?php echo $_SESSION['level']; ?>">
                                                        <button type="submit" name="btn_add_course" class="btn btn-sm btn-success" onclick="return confirm('Add this course')"><i class="fa fa-plus"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                            <tr>
                                                <td colspan="4" style="text-align: right;font-weight: bold; color: black;">Total Course Unit </td>
                                                <td colspan="4" style="text-align: left;font-weight: bold; color: black;">
                                                <?php 
                                                    $course_count = 0;
                                                    $sql = "SELECT SUM(unit) FROM tbl_added_courses WHERE level = '{$_SESSION['level']}' AND program = '{$_SESSION['program']}' AND department = '{$_SESSION['department']}' AND session = '{$_SESSION['ses']}' AND semester = '{$_SESSION['sem']}' ";
                                                    $query_result = mysqli_query($conn, $sql);
                                                    $result = mysqli_num_rows($query_result);
                                                        while ($row = mysqli_fetch_array($query_result)) {
                                                            $course_count += $row['SUM(unit)'];
                                                        }
                                                        echo $course_count;
                                                ?>     
                                                 </td>
                                            </tr>
                                        <?php
                                        }else{
                                        ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;">Courses Not Available Yet</td>
                                            </tr>
                                        <?php
                                           } 
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <small><p style="color: red; font-weight: bold;">NOTE: Only use this field, if you rerun a course.</p></small>
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th>Course Code </th>
                                                <th>Course Title</th>
                                                <th>Course Unit </th>
                                                <th>Status </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="c_code" class="form-control" placeholder="Course Code...." disabled=""></td>
                                                <td><input type="text" name="c_title" class="form-control" placeholder="Course Title...." disabled=""></td>
                                                <td><input type="text" name="c_unit" class="form-control" placeholder="Course Unit...." disabled=""></td>
                                                <td><input type="text" name="c_status" class="form-control" placeholder="Course Status...."  disabled=""></td>
                                                <td><button type="submit" name="btn_remove" class="btn btn-sm btn-success" disabled="">Add</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Registered for, for the Current Semester and Session -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>List of courses you selected for this semester and session </h4>
                            <small><p style="color: red;">NOTE: Always click on the submit button after selecting your courses.</p></small>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Course Code </th>
                                                <th>Course Title</th>
                                                <th>Course Unit </th>
                                                <th>Status </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbl_submitted_courses WHERE session = '{$_SESSION['ses']}' AND semester = '{$_SESSION['sem']}' AND matricno = '{$_SESSION['matricno']}' AND status='Pending' ORDER BY course_code, title ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($rows = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $rows['course_code']; ?></td>
                                                <td><?php echo $rows['title']; ?></td>
                                                <td><?php echo $rows['unit']; ?></td>
                                                <td><?php echo $rows['grade']; ?></td>
                                                <td>
                                                    <form action="courses.php" method="POST">
                                                        <input type="hidden" name="c_code2" value="<?php echo $rows['course_code']; ?>">
                                                        <input type="hidden" name="c_session2" value="<?php echo $rows['session']; ?>">
                                                        <input type="hidden" name="c_semester2" value="<?php echo $rows['semester']; ?>">
                                                        <input type="hidden" name="stu_matricno2" value="<?php echo $rows['matricno']; ?>">
                                                        <input type="hidden" name="stu_level2" value="<?php echo $rows['level']; ?>">
                                                        <button type="submit" name="btn_remove_course" class="btn btn-sm btn-danger" onclick="return confirm('Remove this Course?');"><i class="fa fa-times"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }
                                        }else{
                                            $sql = "SELECT * FROM tbl_submitted_courses WHERE session = '{$_SESSION['ses']}' AND semester = '{$_SESSION['sem']}' AND matricno = '{$_SESSION['matricno']}' ORDER BY course_code, title ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result1 = mysqli_num_rows($query_result);
                                            if($result1 > 0){
                                        ?>
                                            <?php if($result1['status'] == "Submitted"): ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;">You have already submitted the courses for this session and semester</td>
                                            </tr>
                                            <?php endif; ?>
                                        <?php
                                           }
                                           else{
                                        ?>
                                            <?php if($result1['status'] == "Pending" || $result1['status'] == "" || $result1['status'] == null): ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;">You have not registered the courses for this session and semester</td>
                                            </tr>
                                            <?php endif; ?>
                                        <?php    
                                           }
                                           } 
                                        ?>
                                    </table>
                                </div>
                                <form action="courses.php" method="POST">
                                    <button type="submit" name="btn_final_submit" class="btn btn-lg btn-primary" onclick="return confirm('Submit Course?');">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
</body>

</html>