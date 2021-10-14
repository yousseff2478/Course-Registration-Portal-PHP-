<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['matricno'])){
        if(isset($_POST['btn_update'])){
            $surname = $_POST['surname'];
            $othername = $_POST['othername'];
            $level = $_POST['level'];
            $program = $_POST['program'];
            $faculty = $_POST['faculty'];
            $gender = $_POST['gender'];
            $department = $_POST['department'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $surname = mysqli_real_escape_string($conn, $surname);
            $othername = mysqli_real_escape_string($conn, $othername);
            $level = mysqli_real_escape_string($conn, $level);
            $program = mysqli_real_escape_string($conn, $program);
            $faculty = mysqli_real_escape_string($conn, $faculty);
            $gender = mysqli_real_escape_string($conn, $gender);
            $department = mysqli_real_escape_string($conn, $department);
            $email = mysqli_real_escape_string($conn, $email);
            $phone = mysqli_real_escape_string($conn, $phone);
            $address = mysqli_real_escape_string($conn, $address);

            if(empty($surname) || empty($othername) || empty($email)){
                $_SESSION['ErrorMessage'] = "Please fill all necessary fields";
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['ErrorMessage'] = "Invalid email address provided";
            }else if(!preg_match("/^[\d]*$/", $phone)){
                $_SESSION['ErrorMessage'] = "Only numbers allowed for the phone no field";
            }else{
                $sql = "UPDATE tblstudent SET surname='$surname',othername='$othername',level='$level',program='$program',faculty='$faculty',gender='$gender',department='$department',email='$email',phone='$phone',address='$address' WHERE matricno='{$_SESSION['matricno']}' ";
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
                $sql = "SELECT * FROM tblstudent WHERE matricno = '{$_SESSION['matricno']}' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    while($row = mysqli_fetch_assoc($query_result)){
                        $getpassword = $row['password'];
                    }

                    if(password_verify($password, $getpassword)){
                        $newpassword = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "UPDATE tblstudent SET password='$newpassword' WHERE matricno = '{$_SESSION['matricno']}' ";
                        $query_result = mysqli_query($conn, $sql);

                        if($query_result){
                            $_SESSION['SuccessMessage'] = "Password has been changed successfully";
                        }else{
                            $_SESSION['ErrorMessage'] = "Failed to change your password";
                        }
                    }
                }else{
                    $_SESSION['ErrorMessage'] = "Old Password Provided is Incorrect";
                }
            }
        }elseif(isset($_POST['btn_update_picture'])){

            $image_name = $_FILES['student_pix']['name'];
            $target = "./images/profile_pic/" . $_FILES['student_pix']['name'];
            //echo $image_name;

            if ($_FILES['student_pix']['size'] >10000000 ){
                $_SESSION['WarningMessage'] = "File Size Too Large";
            }
            else{
                $sql = "SELECT * FROM tblstudent WHERE matricno = '{$_SESSION['matricno']}' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    while($row = mysqli_fetch_array($query_result)){
                        if($image_name == null){
                            // Update with existing image
                            $new_image = $row['image'];
                        }
                        else {
                            // Update with new image and delete the old image
                            $default_image = "default.png";
                            if($img_path = "./images/profile_pic/" .$row['image'] AND $default_image == $row['image']){
                                #unlink($img_path);
                                $new_image = $image_name;
                            }elseif($img_path = "./images/profile_pic/" .$row['image']){
                                unlink($img_path);
                                $new_image = $image_name;
                            }
                        }
                    }
                }

                $sql = "UPDATE tblstudent SET image = '$new_image' WHERE matricno = '{$_SESSION['matricno']}' ";
                $query_result = mysqli_query($conn, $sql);
                if($query_result){ 
                    $_SESSION['SuccessMessage'] = "Profile picture has been changed successfully";
                    //Move image to temporary file location
                    move_uploaded_file($_FILES['student_pix']['tmp_name'], $target);
                }else{
                    $_SESSION['ErrorMessage'] = "Failed to change profile picture";
                }

                #$_SESSION['picture'] = "default.png";
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
    <title>Edit Profile</title>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css">
    <?php include_once('includes/styles.html'); ?>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
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
                    <!-- Change Profile Picture -->
                    <div class="gist-status">
                        <h4><i class="fa fa-image"></i> Change Profile Picture<small><a href="profile.php"><span class="pull-right"><span class="pull-right">Back to profile <i class="fa fa-arrow-right"></i></span></a></small></h4>
                        <hr>
                        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="img-wrap">
                                    <?php if($_SESSION['picture'] != "default.png"): ?>
                                        <img class="img-circle status-image" src="images/profile_pic/<?php echo $_SESSION['picture']; ?>" width="100" height="100" style="margin-bottom: 5px;">
                                    <?php else: ?>
                                        <img class="img-circle status-image" src="images/pic/<?php echo $_SESSION['picture']; ?>" width="100" height="100" style="margin-bottom: 5px;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-body">
                                <label>Select Picture</label>
                                <input type="file" name="student_pix" class="form-control">
                            </div>
                                                  
                            <div class="form-body">
                                <button type="submit" class="btn btn-sm btn-primary" name="btn_update_picture"><i class="fa fa-image"></i> Update Picture</button>
                            </div>
                        </form>
                    </div>

                    <!-- Edit Profile Information -->
                    <div class="gist-status">
                        <h4><i class="fa fa-edit"></i> Edit Profile Information<small><a href="profile.php"><span class="pull-right"><span class="pull-right">Back to profile <i class="fa fa-arrow-right"></i></span></a></small></h4>
                        <hr>
                        <form action="edit_profile.php" method="post">
                            <?php
                                $sql = "SELECT * FROM tblstudent WHERE matricno = '{$_SESSION['matricno']}' ";
                                $query_result = mysqli_query($conn, $sql);
                                $result = mysqli_num_rows($query_result);
                                if($result > 0){
                                    while($rows = mysqli_fetch_array($query_result)){

                            ?>
                            <div class="col-sm-6">
                                <div class="form-body">
                                    <span id="sprytextfield2">
                                      <label for="Firstname">Surname</label>
                                      <input type="text" name="surname" id="Firstname" class="form-control" value="<?php echo $rows['surname']; ?>" readonly>
                                      <span class="textfieldRequiredMsg">Please enter your surname name.</span>
                                    </span> 
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-body">
                                  <span id="sprytextfield3">
                                    <label for="Othername">Other Names</label>
                                    <input type="text" name="othername" id="Othername" class="form-control" value="<?php echo $rows['othername']; ?>" readonly>
                                  <span class="textfieldRequiredMsg">Please enter your other names.</span></span> 
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-body">
                                    <label for="level">Level</label>
                                    <input type="text" name="level" class="form-control" id="level" readonly value="<?php echo $rows['level']; ?>">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-body">
                                    <label for="">Program</label>
                                    <input type="text" name="program" class="form-control" id="program" readonly value="<?php echo $rows['program']; ?>">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-body">
                                    <label for="faculty">Faculty</label>
                                    <input type="text" name="faculty" class="form-control" id="faculty" readonly value="<?php echo $rows['faculty']; ?>">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-body">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="<?php echo $rows['gender']; ?>"><?php echo $rows['gender']; ?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-body">
                                    <label for="department">Department</label>
                                    <input type="text" name="department" class="form-control" id="department" readonly value="<?php echo $rows['department']; ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-body">
                                  <span id="sprytextfield4">
                                  <label for="email">E-mail</label>
                                  <input type="email" name="email" id="email" class="form-control" value="<?php echo $rows['email']; ?>" readonly>
                                  <span class="textfieldRequiredMsg">Enter email address.</span><span class="textfieldInvalidFormatMsg">Invalid email format.</span></span> 
                                </div>
                            </div> 

                            <div class="col-sm-6">
                                <div class="form-body">
                                  <label for="phone">Phone No.</label>
                                  <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $rows['phone']; ?>"> 
                                </div>
                            </div> 

                            <div class="col-sm-6">
                                <div class="form-body">
                                  <label for="address">Address</label>
                                  <textarea name="address" class="form-control" value="<?php echo $rows['address']; ?>"><?php echo $rows['address']; ?></textarea>
                                </div>
                            </div> 
                            <?php
                                }
                            }
                            ?>
                            <div class="form-body" style="margin-left: 15px;">
                                <button type="submit" class="btn btn-sm btn-primary" name="btn_update"><i class="fa fa-user-plus"></i> Update Profile</button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="gist-status">
                        <h4><i class="fa fa-lock"></i> Change Password<small><a href="profile.php"><span class="pull-right"><span class="pull-right">Back to profile <i class="fa fa-arrow-right"></i></span></a></small></h4>
                        <hr>
                        <form action="edit_profile.php" method="post">
                            <div class="col-sm-12">
                                <div class="form-body">
                                    <span id="oldpassword">
                                      <label for="oldpassword">Old Password</label>
                                      <input type="password" name="oldpassword" id="oldpassword" class="form-control">
                                    <span class="passwordRequiredMsg">Enter a password for your account.</span><span class="passwordMinCharsMsg">password must be more than six (6) characters.</span><span class="passwordMaxCharsMsg">Password must be less than 18 characters.</span></span> 
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-body">
                                    <span id="sprypassword1">
                                      <label for="newpassword">Password</label>
                                      <input type="password" name="password" id="newpassword" class="form-control">
                                    <span class="passwordRequiredMsg">Enter a password for your account.</span><span class="passwordMinCharsMsg">password must be more than six (6) characters.</span><span class="passwordMaxCharsMsg">Password must be less than 18 characters.</span></span> 
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-body">
                                    <span id="sprypassword2">
                                    <label for="password2">Confirm Password</label>
                                    <input type="password" name="password2" id="newpassword" class="form-control">
                                    <span class="confirmRequiredMsg">Please confirm your password.</span><span class="confirmInvalidMsg">The password does not match your previous password.</span></span> 
                                </div>
                            </div>
                            
                            <div class="form-body" style="margin-left: 15px;">
                                <button type="submit" class="btn btn-sm btn-primary" name="btn_update_password"><i class="fa fa-user-plus"></i> Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur", "change"], minChars:6, maxChars:18});
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2", {validateOn:["blur", "change"], minChars:6, maxChars:18});
var oldpassword = new Spry.Widget.ValidationPassword("oldpassword", {validateOn:["blur", "change"], minChars:6, maxChars:18});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["blur", "change"]});
</script>
</body>
</html>
