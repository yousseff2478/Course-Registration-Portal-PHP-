<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        global $stu_id, $stu_fullname, $stu_gender, $stu_level,$stu_department,$stu_faculty,$stu_email,$stu_program,$stu_image,$stu_status;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM tblstudent WHERE matricno = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            $result = mysqli_num_rows($query_result);
            if($result > 0){
                while($row = mysqli_fetch_array($query_result)){
                    $stu_id = $row['matricno'];
                    $stu_fullname = $row['surname'] ." ". $row['othername'];
                    $stu_gender = $row['gender'];
                    $stu_level = $row['level'];
                    $stu_department = $row['department'];
                    $stu_faculty = $row['faculty'];
                    $stu_email = $row['email'];
                    $stu_program = $row['program'];
                    $stu_image = $row['image'];
                    $stu_status = $row['status'];
                }
            }
        }elseif (isset($_POST['btn_disable'])) {
            $student_id = $_POST['student_id'];

            $student_id = mysqli_real_escape_string($conn, $student_id);
            $sql = "UPDATE tblstudent SET status = 'In-active' WHERE matricno = '$student_id' ";
            $query_result = mysqli_query($conn, $sql);

            if($query_result){
                $_SESSION['SuccessMessage'] = "Student Account has been disabled";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to disable student account";
            }
            RedirectTo('dashboard.php');
        }elseif (isset($_POST['btn_enable'])) {
            $student_id = $_POST['student_id'];

            $student_id = mysqli_real_escape_string($conn, $student_id);
            $sql = "UPDATE tblstudent SET status = 'Active' WHERE matricno = '$student_id' ";
            $query_result = mysqli_query($conn, $sql);

            if($query_result){
                $_SESSION['SuccessMessage'] = "Student Account has been enabled";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to enable student account";
            }
            RedirectTo('dashboard.php');
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
    <title>Profile</title>
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
                    <div class="gist-status">
                        <div class="media status-head">
                            <div class="media-left">
                                <a><img class="status-image" src="../images/profile_pic/<?php echo $stu_image; ?>" width="100" height="100"></a>
                            </div>
                            <div class="media-body">
                                <div class="follow-head">
                                    <div class="col-sm-12">
                                        <h4><?php echo $stu_fullname; ?></h4>
                                        <h5 class="text-left text-muted status-text" style="margin-bottom: 10px;"><?php echo $stu_email; ?></h5>
                                        <form method="POST" action="view_profile.php">
                                        <?php if($stu_status == "Active"): ?>
                                            <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                            <button type="submit" class="btn btn-danger" name="btn_disable" onclick="return confirm('Disable this Account?')">Disable Account</button>
                                        <?php elseif($stu_status == "In-active"): ?>
                                            <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                            <button type="submit" class="btn btn-success" name="btn_enable" onclick="return confirm('Enable this Account?')">Enable Account</button>
                                        <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gist-status">
                        <h4>Student Information</h4>
                        <hr>
                        <h4><?php echo $stu_fullname; ?></h4>
                        <h5><?php echo $stu_faculty; ?></h5>
                        <h5><?php echo $stu_department; ?></h5>
                        <h5><?php echo $stu_program; ?></h5>
                        <h5><?php echo $stu_level; ?></h5>
                        <h5><?php echo $stu_gender; ?></h5>
                        <h5><?php echo $stu_email; ?></h5>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
</body>

</html>