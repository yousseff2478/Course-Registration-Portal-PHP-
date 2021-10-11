<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        if(isset($_POST['btn_update'])){
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $username = mysqli_real_escape_string($conn, $username);
            $fullname = mysqli_real_escape_string($conn, $fullname);
            $email = mysqli_real_escape_string($conn, $email);
            $phone = mysqli_real_escape_string($conn, $phone);
            $address = mysqli_real_escape_string($conn, $address);

            if(empty($username) || empty($fullname) || empty($email)){
                $_SESSION['ErrorMessage'] = "Please fill all necessary fields";
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['ErrorMessage'] = "Invalid email address provided";
            }else if(!preg_match("/^[\d]*$/", $phone)){
                $_SESSION['ErrorMessage'] = "Only numbers allowed for the phone no field";
            }else{
                $sql = "UPDATE tbluser SET fullname='$fullname',phone='$phone',address='$address' WHERE username='{$_SESSION['username']}' ";
                $query_result = mysqli_query($conn, $sql);

                if($query_result){
                    $_SESSION['SuccessMessage'] = "Your profile has been updated successfully";
                }else{
                    $_SESSION['ErrorMessage'] = "Failed to update profile";
                }
            }
        }elseif(isset($_POST['btn_update_password'])){
            $oldpassword = $_POST['oldpassword'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $oldpassword = mysqli_real_escape_string($conn, $oldpassword);
            $password = mysqli_real_escape_string($conn, $password);
            $password2 = mysqli_real_escape_string($conn, $password2);

            if($password != $password2){
                $_SESSION['ErrorMessage'] = "Both new password provided do not match";
            }else{
                $sql = "SELECT * FROM tbluser WHERE username = '{$_SESSION['username']}' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    while($row = mysqli_fetch_assoc($query_result)){
                        $getpassword = $row['password'];
                    }

                    if(password_verify($password, $getpassword)){
                        $newpassword = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "UPDATE tbluser SET password='$newpassword' WHERE username = '{$_SESSION['username']}' ";
                        $query_result = mysqli_query($conn, $sql);

                        if($query_result){
                            $_SESSION['SuccessMessage'] = "User password has been updated successfully";
                        }else{
                            $_SESSION['ErrorMessage'] = "Failed to update your password";
                        }
                    }
                }else{
                    $_SESSION['ErrorMessage'] = "Old Password Provided is Incorrect";
                }
            }
        }elseif(isset($_POST['btn_update_picture'])){

            $image_name = $_FILES['user_pix']['name'];
            $target = "./uploads/admin_pic/" . $_FILES['user_pix']['name'];
            //echo $image_name;

            if ($_FILES['user_pix']['size'] >10000000 ){
                $_SESSION['WarningMessage'] = "File Size Too Large";
            }
            else{
                $sql = "SELECT * FROM tbluser WHERE username = '{$_SESSION['username']}' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    while($row = mysqli_fetch_array($query_result)){
                        if($image_name == null){
                            // Update with existing image
                            $new_image = $row['picture'];
                        }
                        else {
                            // Update with new image and delete the old image
                            $default_image = "default.png";
                            if($img_path = "./uploads/admin_pic/" .$row['picture'] AND $default_image == $row['picture']){
                                #unlink($img_path);
                                $new_image = $image_name;
                            }elseif($img_path = "./uploads/admin_pic/" .$row['picture']){
                                unlink($img_path);
                                $new_image = $image_name;
                            }
                        }
                    }
                }

                $sql = "UPDATE tbluser SET picture = '$image_name' WHERE username = '{$_SESSION['username']}' ";
                $query_result = mysqli_query($conn, $sql);
                if($query_result){ 
                    $_SESSION['SuccessMessage'] = "Profile picture has been changed successfully";
                    //Move image to temporary file location
                    move_uploaded_file($_FILES['user_pix']['tmp_name'], $target);
                }else{
                    $_SESSION['ErrorMessage'] = "Failed to change profile picture";
                }
                $_SESSION['picture'] = $new_image;
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
    <title><?php echo $_SESSION['username']; ?>'s Profile</title>
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
                   <?php include_once('includes/leftside.php'); ?>
                </div>

                <div class="col-md-8 col"> 
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?>   
                    <div class="gist-status">
                        <div class="media status-head">
                            <div class="media-left">
                                <a><img class="status-image" src="./uploads/admin_pic/<?php echo $_SESSION['picture']; ?>" width="100" height="100"></a>
                            </div>
                            <div class="media-body">
                                <div class="follow-head">
                                    <div class="col-sm-12">
                                        <h4>Change Profile Picture</h4>
                                        <hr>
                                        <div class="form-group">
                                            <form action="profile.php" method="POST" enctype="multipart/form-data">
                                                <div class="col-sm-8">
                                                    <input type="file" name="user_pix" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button class="btn btn-primary" type="submit" name="btn_update_picture"><i class="fa fa-image"></i>   Change Picture</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Edit Profile<small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="form-group">
                                <form action="profile.php" method="POST">
                                    <?php
                                    $sql = "SELECT * FROM tbluser WHERE username = '{$_SESSION['username']}' ";
                                    $query_result = mysqli_query($conn, $sql);
                                    $result = mysqli_num_rows($query_result);
                                    if($result > 0){
                                        while($row = mysqli_fetch_array($query_result)){

                                    ?>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield1">
                                              <label for="username">Username</label>
                                              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username..." value="<?php echo $row['username']; ?>" readonly>
                                              <span class="textfieldRequiredMsg">Please enter a username.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield2">
                                                <label for="fullname">Full Name</label>
                                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Fullname..." value="<?php echo $row['fullname']; ?>">
                                                <span class="textfieldRequiredMsg">Please enter fullname.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <span id="sprytextfield3">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email..." value="<?php echo $row['email']; ?>" readonly>
                                                <span class="textfieldRequiredMsg">Please enter an email address.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-body">
                                            <label for="phone">Phone No</label>
                                            <input type="text" name="phone" id="phone" class="form-control" maxlength="11" placeholder="Enter Phone No..." value="<?php echo $row['phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <label for="address">Address</label>
                                            <textarea type="text" name="address" id="address" class="form-control" placeholder="Enter Address..." ><?php echo $row['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <div class="col-sm-12">
                                        <button style="margin-top: 5px;" class="btn btn-primary" type="submit" name="btn_update"><i class="fa fa-plus"></i> Update Profile</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>

                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Change Password<small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="form-group">
                                <form action="profile.php" method="POST">
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <span id="sprytextfield4">
                                              <label for="oldpassword">Old Password</label>
                                              <input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Enter Old Password...">
                                              <span class="textfieldRequiredMsg">Please enter your old password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <span id="sprytextfield5">
                                              <label for="password">New Password</label>
                                              <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <span id="sprytextfield6">
                                              <label for="password2">Confirm New Password</label>
                                              <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm New Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button style="margin-top: 5px;" class="btn btn-primary" type="submit" name="btn_update_password"><i class="fa fa-plus"></i> Change Password</button>
                                    </div>
                            </form>
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
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
</script>
</body>

</html>