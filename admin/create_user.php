<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        if(isset($_POST['btn_save'])){
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $username = mysqli_real_escape_string($conn, $username);
            $fullname = mysqli_real_escape_string($conn, $fullname);
            $email = mysqli_real_escape_string($conn, $email);
            $phone = mysqli_real_escape_string($conn, $phone);
            $address = mysqli_real_escape_string($conn, $address);
            $password = mysqli_real_escape_string($conn, $password);
            $password2 = mysqli_real_escape_string($conn, $password2);

            $fullname = strtoupper($fullname);
            
            if(empty($username) || empty($fullname) || empty($email) || empty($password) || empty($password2)){
                $_SESSION['ErrorMessage'] = "Please fill all necessary fields";
            }elseif($password != $password2){
                $_SESSION['ErrorMessage'] = "Both password provided do not match";
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['ErrorMessage'] = "Invalid email address provided";
            }else if(!preg_match("/^[\d]*$/", $phone)){
                $_SESSION['ErrorMessage'] = "Only numbers allowed for the phone no field";
            }else{
                $sql = "SELECT * FROM tbluser WHERE username = '$username' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Username Already Exist";
                }else{

                    $sql = "SELECT * FROM tbluser WHERE email = '$email' ";
                    $query_result = mysqli_query($conn, $sql);
                    $result = mysqli_num_rows($query_result);
                    if($result > 0){
                        $_SESSION['ErrorMessage'] = "Email Address Already Exist";
                    }else{
                        $pass = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "INSERT INTO tbluser (username,fullname,email,phone,address,password,picture,status,usertype) VALUES('$username','$fullname','$email','$phone','$address','$pass','default.png','Active','Admin') ";
                        $query_result = mysqli_query($conn, $sql);

                        if($query_result){
                            $_SESSION['SuccessMessage'] = "User account has been created successfully";
                            //move_uploaded_file($image_name, $target);
                        }else{
                            $_SESSION['ErrorMessage'] = "Failed to create user account";
                        }
                    }
                }
            }
        }elseif (isset($_POST['btn_disable'])) {
            $id = $_POST['user_name'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "UPDATE tbluser SET status = 'In-active' WHERE username = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "User account has been disabled successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to disable user account";
            }
        }elseif (isset($_POST['btn_undisable'])) {
            $id = $_POST['user_name'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "UPDATE tbluser SET status = 'Active' WHERE username = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "User account has been activated successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to activate account";
            }
        }elseif (isset($_POST['btn_delete'])) {
            $id = $_POST['user_name'];

            $id = mysqli_real_escape_string($conn, $id);

            $sql = "DELETE FROM tbluser WHERE username = '$id' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "User account has been deleted successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to delete user account";
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
    <title>Create User</title>
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
                            <h4>Create User Account<small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="form-group">
                                <form action="create_user.php" method="POST">
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield1">
                                              <label for="username">Username</label>
                                              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username...">
                                              <span class="textfieldRequiredMsg">Please enter a username.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield2">
                                              <label for="fullname">Full Name</label>
                                              <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Fullname...">
                                              <span class="textfieldRequiredMsg">Please enter fullname.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield3">
                                              <label for="email">Email</label>
                                              <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email...">
                                              <span class="textfieldRequiredMsg">Please enter an email address.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <label for="phone">Phone No</label>
                                            <input type="text" name="phone" id="phone" class="form-control" maxlength="11" placeholder="Enter Phone No...">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <label for="address">Address</label>
                                            <textarea type="text" name="address" id="address" class="form-control" placeholder="Enter Address..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield4">
                                              <label for="password">Password</label>
                                              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield5">
                                              <label for="password2">Confirm Password</label>
                                              <input type="password" name="password2" id="password2" class="form-control" placeholder="Enter Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button style="margin-top: 5px;" class="btn btn-primary" type="submit" name="btn_save"><i class="fa fa-plus"></i> Save User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Record -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>List of All User's<small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Disable</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbluser WHERE username != '{$_SESSION['username']}' AND usertype = 'Admin' ORDER BY username ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($row = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['fullname']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td>
                                                    <form action="create_user.php" method="POST">
                                                        <input type="hidden" name="user_name" value="<?php echo $row['username']; ?>">
                                                    <?php if($row['status'] == "Active"): ?>
                                                        <span style="color: red; font-size: 16px;"><button type="submit" class="btn btn-warning btn-sm" name="btn_disable" onclick="return confirm('Disable this account?')"><i class="fa fa-lock"></i></span></button>
                                                    <?php elseif($row['status'] == "In-active"): ?>
                                                        <span style="color: red; font-size: 16px;"><button type="submit" class="btn btn-success btn-sm" name="btn_undisable" onclick="return confirm('Activate this account?')"><i class="fa fa-unlock"></i></span></button>
                                                    <?php endif; ?>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="create_user.php" method="POST">
                                                        <input type="hidden" name="user_name" value="<?php echo $row['username']; ?>">
                                                        <span style="color: red; font-size: 16px;"><button type="submit" class="btn btn-danger btn-sm" name="btn_delete" onclick="return confirm('Delete this Record?')"><i class="fa fa-trash"></i></span></button>
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
</script>
</body>

</html>