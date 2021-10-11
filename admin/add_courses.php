<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        global $sem, $ses_from, $ses_to;

        if(isset($_POST['btn_save_course'])){
            $semester = $_POST['semester'];
            $session = $_POST['session'];
            $session2 = $_POST['session2'];
            $course_code = $_POST['course_code'];
            $course_title = $_POST['course_title'];
            $course_unit = $_POST['course_unit'];
            $course_grade = $_POST['course_grade'];
            $level = $_POST['level'];
            $program = $_POST['program'];
            $department = $_POST['department'];

            $semester = mysqli_real_escape_string($conn, $semester);
            $session = mysqli_real_escape_string($conn, $session);
            $session2 = mysqli_real_escape_string($conn, $session2);
            $course_code = mysqli_real_escape_string($conn, $course_code);
            $course_title = mysqli_real_escape_string($conn, $course_title);
            $course_unit = mysqli_real_escape_string($conn, $course_unit);
            $course_grade = mysqli_real_escape_string($conn, $course_grade);
            $level = mysqli_real_escape_string($conn, $level);
            $program = mysqli_real_escape_string($conn, $program);
            $department = mysqli_real_escape_string($conn, $department);

            $course_code = strtoupper($course_code);
            $course_title = strtoupper($course_title);
            $course_grade = strtoupper($course_grade);

            $newsession = $session ."-". $session2;

            if(empty($semester) || empty($session) || empty($session2)){
                $_SESSION['ErrorMessage'] = "Semester/Sesion has not been set";
            }elseif(empty($course_code) || empty($course_title) || empty($course_unit) || empty($course_grade)){
                $_SESSION['ErrorMessage'] = "Please fill all fields";
            }else if(!preg_match("/^[\d]*$/", $course_unit)){
                $_SESSION['ErrorMessage'] = "Only numbers allowed for the course unit field";
            }else{
                $sql = "SELECT * FROM tbl_added_courses WHERE course_code = '$course_code' AND level = '$level' AND program = '$program' AND department = '$department' AND session = '$newsession' AND semester ='$semester' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "This course already exist for this level, program, session, semester and department";
                }else{
                    $sql = "INSERT INTO tbl_added_courses (course_code,title,unit,grade,level,program,department,semester,session) VALUES('$course_code','$course_title','$course_unit','$course_grade','$level','$program','$department','$semester','$newsession') ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Course added successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to add course";
                    }
                }
            }
        }elseif(isset($_POST['btn_delete'])){
            $c_code = $_POST['c_code'];
            $c_level = $_POST['c_level'];
            $c_department = $_POST['c_department'];
            $c_program = $_POST['c_program'];
            $c_semester = $_POST['c_semester'];
            $c_session = $_POST['c_session'];

            $c_code = mysqli_real_escape_string($conn, $c_code);
            $c_level = mysqli_real_escape_string($conn, $c_level);
            $c_department = mysqli_real_escape_string($conn, $c_department);
            $c_program = mysqli_real_escape_string($conn, $c_program);
            $c_semester = mysqli_real_escape_string($conn, $c_semester);
            $c_session = mysqli_real_escape_string($conn, $c_session);

            $sql = "DELETE FROM tbl_added_courses WHERE course_code='$c_code' AND level='$c_level' AND program ='$c_program' AND department='$c_department' AND semester='$c_semester' AND session='$c_session' ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Course has been removed successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to remove course";
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
    <title>Add Courses</title>
    <?php include_once('includes/styles.html') ?>
    <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
    <?php include_once('includes/nav.php') ?>
    <section class="container-wrap">
        <div class="container wrap">
            <div class="row">
                <div class="col-md-4 col">
                   <?php include_once('includes/leftside.php') ?>
                </div>

                <!-- Add Level -->
                <div class="col-md-8 col">
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?>
                     <!-- Add Courses -->
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
                                <h4>Add Courses<small><strong><span style="color: black;" class="pull-right"><?php echo $sem; ?> / <?php echo $ses_from; ?>-<?php echo $ses_to; ?></span></strong></small></h4>
                            <?php else: ?>
                                <h4>Add Courses<small><strong><span style="color: black;" class="pull-right">No Semester/Session Set</span></strong></small></h4>
                            <?php endif; ?>
                            <hr>
                            <div class="form-group">
                                <form action="add_courses.php" method="POST">
                                    <?php
                                        $sql = "SELECT * FROM tblsemester WHERE status = 'Open' ";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        if($result > 0){
                                            while($rows = mysqli_fetch_assoc($query_result)){
                                                $sem1 = $rows['semester'];
                                                $ses_from1 = $rows['session_from'];
                                                $ses_to1 = $rows['session_to'];
                                            }
                                        }else{
                                            $sem1 = "";
                                            $ses_from1 = "";
                                            $ses_to1 = "";
                                        }
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="form-body">
                                            <input type="hidden" name="semester" id="semester" class="form-control" placeholder="" value="<?php echo $sem1; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-body">
                                            <input type="hidden" name="session" id="session" class="form-control" placeholder="" value="<?php echo $ses_from1; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-body">
                                            <input type="hidden" name="session2" id="session2" class="form-control" placeholder="" value="<?php echo $ses_to1; ?>">
                                        </div>
                                    </div>
                                    <?php

                                    ?>
                                    <div class="col-sm-3">
                                        <div class="form-body">
                                            <span id="sprytextfield1">
                                              <label for="Matric">Course Code</label>
                                              <input type="text" name="course_code" id="course_code" class="form-control" placeholder="eg. COM 301">
                                              <span class="textfieldRequiredMsg">Please enter the course code.</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-body">
                                            <span id="sprytextfield2">
                                              <label for="Matric">Course Title</label>
                                              <input type="text" name="course_title" id="course_title" class="form-control" placeholder="eg. Application Packages">
                                              <span class="textfieldRequiredMsg">Please enter the course title.</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-body">
                                            <span id="sprytextfield3">
                                              <label for="Matric">Course Unit</label>
                                              <input type="text" name="course_unit" id="course_unit" class="form-control" maxlength="1" placeholder="eg. 2">
                                              <span class="textfieldRequiredMsg">Please enter the course unit</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-body">
                                            <span id="sprytextfield4">
                                              <label for="Matric">Grade</label>
                                              <input type="text" name="course_grade" id="course_grade" class="form-control" placeholder="eg. C">
                                              <span class="textfieldRequiredMsg">Please enter the course grade.</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-body">
                                            <label for="">Level</label>
                                            <select name="level" class="form-control" id="level">
                                            <?php
                                                $sql = "SELECT * FROM tbllevel ORDER BY name ASC";
                                                $query_result = mysqli_query($conn, $sql);
                                                $result = mysqli_num_rows($query_result);
                                                if($result > 0){
                                                  while($row = mysqli_fetch_array($query_result)){
                                            ?>
                                                  <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                                }
                                              }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-body">
                                            <label for="">Program</label>
                                            <select name="program" class="form-control" id="program">
                                                <option value="FT">FT</option>
                                                <option value="DPP">DPP</option>
                                                <option value="PT">PT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <label for="">Department</label>
                                            <select name="department" class="form-control" id="department">
                                            <?php
                                                $sql = "SELECT * FROM tbldepartment ORDER BY department ASC";
                                                $query_result = mysqli_query($conn, $sql);
                                                $result = mysqli_num_rows($query_result);
                                                if($result > 0){
                                                  while($row = mysqli_fetch_array($query_result)){
                                            ?>
                                                  <option value="<?php echo $row['department']; ?>"><?php echo $row['department']; ?></option>
                                            <?php
                                                }
                                              }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button style="margin-top: 5px;" class="btn btn-primary" type="submit" name="btn_save_course"><i class="fa fa-plus"></i> Add Course</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Record -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>List of All Added Courses<small><span class="pull-right"></span></small> </h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Course Code</th>
                                                <th>Title</th>
                                                <th>Unit </th>
                                                <th>Grade</th>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Session</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbl_added_courses ORDER BY department ASC";
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
                                                <td><?php echo $row['level']; ?></td>
                                                <td><?php echo $row['program']; ?></td>
                                                <td><?php echo $row['department']; ?></td>
                                                <td><?php echo $row['semester']; ?></td>
                                                <td><?php echo $row['session']; ?></td>
                                                <td>
                                                    <form action="add_courses.php" method="POST">
                                                        <input type="hidden" name="c_code" value="<?php echo $row['course_code']; ?>">
                                                        <input type="hidden" name="c_level" value="<?php echo $row['level']; ?>">
                                                        <input type="hidden" name="c_department" value="<?php echo $row['department']; ?>">
                                                        <input type="hidden" name="c_program" value="<?php echo $row['program']; ?>">
                                                        <input type="hidden" name="c_semester" value="<?php echo $row['semester']; ?>">
                                                        <input type="hidden" name="c_session" value="<?php echo $row['session']; ?>">
                                                        <span style="color: red; font-size: 16px;">
                                                        <button class="btn btn-danger btn-sm" type="submit" name="btn_delete" onclick="return confirm('Delete this Record?')"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>    
        </div>
    </section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/user.js"></script>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
</script>
</body>

</html>