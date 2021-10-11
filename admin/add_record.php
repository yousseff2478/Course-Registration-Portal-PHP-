<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');
    
    if(isset($_SESSION['username'])){
        if(isset($_POST['btn_level'])){
            $level = $_POST['level'];

            $level = mysqli_real_escape_string($conn, $level);

            $level = strtoupper($level);
            
            if(empty($level)){
                $_SESSION['ErrorMessage'] = "Please Enter a Valid Level";
            }else{
                $sql = "SELECT * FROM tbllevel WHERE name = '$level' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Level Already Exist";
                }else{
                    $sql = "INSERT INTO tbllevel (name) VALUES('$level') ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Level added successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to add level";
                    }
                }
            }
        }else if(isset($_POST['btn_faculty'])){
            $faculty = $_POST['faculty'];

            $faculty = mysqli_real_escape_string($conn, $faculty);

            $faculty = strtoupper($faculty);
            
            if(empty($faculty)){
                $_SESSION['ErrorMessage'] = "Please Enter a Valid Faculty";
            }else{
                $sql = "SELECT * FROM tblfaculty WHERE name = '$faculty' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Faculty Already Exist";
                }else{
                    $sql = "INSERT INTO tblfaculty (name) VALUES('$faculty') ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Faculty added successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to add faculty";
                    }
                }
            }
        }else if(isset($_POST['btn_department'])){
            $depfaculty = $_POST['depfaculty'];
            $department = $_POST['department'];

            $depfaculty = mysqli_real_escape_string($conn, $depfaculty);
            $department = mysqli_real_escape_string($conn, $department);

            $department = strtoupper($department);
            
            if(empty($department)){
                $_SESSION['ErrorMessage'] = "Please Enter a Valid Department";
            }else{
                $sql = "SELECT * FROM tbldepartment WHERE department = '$department' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Faculty Already Exist";
                }else{
                    $sql = "INSERT INTO tbldepartment (faculty,department) VALUES('$depfaculty','$department') ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Department added successfully";
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to add department";
                    }
                }
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
                            <h4>Add Level</h4>
                            <hr>
                            <div class="form-group">
                                <form action="#" method="POST">
                                    <div class="form-group cen">
                                        <span id="sprytextfield1">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="level" placeholder="Type new Level name....">
                                                <div class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="btn_level"><i class="fa fa-plus"></i> Add Level</button>
                                                </div>
                                            </div>
                                        <span class="textfieldRequiredMsg">Enter Level.</span></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add Faculty -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Add Faculty</h4>
                            <hr>
                            <div class="form-group">
                                <form action="#" method="POST">
                                    <div class="form-group cen">
                                        <span id="sprytextfield2">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="faculty" placeholder="Type new Faculty Department name">
                                                <div class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="btn_faculty"><i class="fa fa-plus"></i> Add Faculty Department</button>
                                                </div>
                                            </div>
                                        <span class="textfieldRequiredMsg">Enter Faculty.</span></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add Department -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Add Department</h4>
                            <hr>
                            <div class="form-group">
                                <form action="add_record.php" method="post">
                                    <div class="form-group cen">
                                        <div class="form-body">
                                            <label for="faculty">Faculty</label>
                                            <select name="depfaculty" class="form-control" id="department">
                                            <?php
                                                $sql = "SELECT * FROM tblfaculty ORDER BY name ASC";
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
                                        <span id="sprytextfield3">
                                            <label for="Department">Department</label>
                                            <input class="form-control" id="Department" type="text" name="department" placeholder="Type new Department name">
                                        <span class="textfieldRequiredMsg">Enter Department.</span></span><br>
                                        <button class="btn btn-primary" type="submit" name="btn_department"><i class="fa fa-plus"></i> Add Department</button>
                                    </div>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/user.js"></script>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
</script>
</body>

</html>