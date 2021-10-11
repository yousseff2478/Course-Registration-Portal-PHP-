<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        if(isset($_POST['btn_save'])){
            $semester = $_POST['semester'];
            $session1 = $_POST['session1'];
            $session2 = $_POST['session2'];

            $semester = mysqli_real_escape_string($conn, $semester);
            $session1 = mysqli_real_escape_string($conn, $session1);
            $session2 = mysqli_real_escape_string($conn, $session2);

            if(empty($session1) || empty($session2)){
                $_SESSION['ErrorMessage'] = "Please fill all fields";
            }else{
                $sql = "SELECT * FROM tblsemester WHERE semester = '$semester' AND session_from = '$session1' AND session_to = '$session2' AND status = 'Open' OR status = 'Close' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Session and Semester has been added Already";
                }else{
                    $sql = "UPDATE tblsemester SET status = 'Close' ";
                    $query_result = mysqli_query($conn, $sql);

                    $sql = "INSERT INTO tblsemester (semester,session_from,session_to,status) VALUES('$semester','$session1','$session2','Open') ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Session and Semester has been added successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to add Session and Semester";
                    }
                }
            }
        }elseif(isset($_POST['btn_delete'])){
            $id = $_POST['semester_id'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "DELETE FROM tblsemester WHERE id = '$id' ";
            $query_result = mysqli_query($conn, $sql);

            if($query_result){
                $_SESSION['SuccessMessage'] = "Session and Semester has been removed successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to remove Session and Semester";
            }
        }elseif(isset($_POST['btn_close'])){
            $id = $_POST['semester_id'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "UPDATE tblsemester SET status = 'Close' ";
            $query_result = mysqli_query($conn, $sql);

            $sql = "UPDATE tblsemester SET status = 'Open' WHERE id = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "The selected Session and Semester has been Opened";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to Open Session and Semester";
            }
        }elseif(isset($_POST['btn_open'])){
            $id = $_POST['semester_id'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "UPDATE tblsemester SET status = 'Close' ";
            $query_result = mysqli_query($conn, $sql);

            $sql = "UPDATE tblsemester SET status = 'Close' WHERE id = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "The selected Session and Semester has been Closed";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to Close Session and Semester";
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
    <title>Semester/Session</title>
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
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Add Semester/Session</h4>
                            <hr>
                            <div class="form-group">
                                <form action="semester.php" method="POST">
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <label for="">Semester</label>
                                            <select name="semester" class="form-control" id="semester">
                                                <option value="First Semester">First Semester</option>
                                                <option value="Second Semester">Second Semester</option>
                                                <option value="Third Semester">Third Semester</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-body">
                                            <span id="sprytextfield1">
                                              <label for="Matric">Session - From</label>
                                              <input type="text" name="session1" id="session" class="form-control" placeholder="eg. 2020" minlength="4" maxlength="4">
                                              <span class="textfieldRequiredMsg">Please enter a valid session.</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-body">
                                            <span id="sprytextfield2">
                                              <label for="Matric">Session - To</label>
                                              <input type="text" name="session2" id="session" class="form-control" placeholder="eg. 2021" minlength="4" maxlength="4">
                                              <span class="textfieldRequiredMsg">Please enter a valid session.</span>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button style="margin-top: 5px;" class="btn btn-primary" type="submit" name="btn_save"><i class="fa fa-plus"></i> Add Semester</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Record -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>List of All Added Semester/Session<small><span class="pull-right"></span></small> </h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Session</th>
                                                <th>From</th>
                                                <th>To </th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 0;
                                        $sql = "SELECT * FROM tblsemester ORDER BY semester ASC";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        if($result > 0){
                                            while($row = mysqli_fetch_assoc($query_result)){
                                                $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['semester']; ?></td>
                                                <td><?php echo $row['session_from']; ?></td>
                                                <td><?php echo $row['session_to']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td>
                                                    <form action="semester.php" method="POST">
                                                    <?php if($row['status'] == "Close"): ?>
                                                        <input type="hidden" name="semester_id" value="<?php echo $row['id']; ?>">
                                                        <button class="btn btn-warning btn-sm" type="submit" name="btn_close" onclick="return confirm('Open this Semester/Session?')">Open</button>
                                                    <?php elseif($row['status'] == "Open"): ?>
                                                        <input type="hidden" name="semester_id" value="<?php echo $row['id']; ?>">
                                                        <button class="btn btn-primary btn-sm" type="submit" name="btn_open" onclick="return confirm('Close this Semester/Session?')">Close</button>
                                                    <?php endif; ?>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="semester.php" method="POST">
                                                        <input type="hidden" name="semester_id" value="<?php echo $row['id']; ?>">
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
</script>
</body>

</html>