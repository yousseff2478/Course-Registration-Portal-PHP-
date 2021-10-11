<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_POST['btn_register'])){
        $matric_no = $_POST['matric_no'];
        $surname = $_POST['surname'];
        $othername = $_POST['othername'];
        $gender = $_POST['gender'];
        $level = $_POST['level'];
        $faculty = $_POST['faculty'];
        $department = $_POST['department'];
        $program = $_POST['program'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        $matric_no = mysqli_real_escape_string($conn, $matric_no);
        $surname = mysqli_real_escape_string($conn, $surname);
        $othername = mysqli_real_escape_string($conn, $othername);
        $gender = mysqli_real_escape_string($conn, $gender);
        $level = mysqli_real_escape_string($conn, $level);
        $faculty = mysqli_real_escape_string($conn, $faculty);
        $department = mysqli_real_escape_string($conn, $department);
        $program = mysqli_real_escape_string($conn, $program);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $cpassword = mysqli_real_escape_string($conn, $cpassword);

        $surname = strtoupper($surname);
        $othername = strtoupper($othername);
        
        if(empty($matric_no) || empty($surname) || empty($othername) || empty($gender) || empty($level) || empty($faculty) || empty($department) || empty($email) || empty($password) || empty($cpassword)){
            $_SESSION['ErrorMessage'] = "All fields are required";
        }else if($password != $cpassword){
            $_SESSION['ErrorMessage'] = "Both password provided is not the same";
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['ErrorMessage'] = "Invalid email address provided";
        }else if(!preg_match("/^[\d]*$/", $matric_no)){
            $_SESSION['ErrorMessage'] = "Only numbers allowed for the matric no field";
        }else if(!preg_match("/^[a-z A-Z]/", $surname)){
            $_SESSION['ErrorMessage'] = "Only alphabet allowed for the surname field";
        }else if(!preg_match("/^[a-z A-Z]/", $othername)){
            $_SESSION['ErrorMessage'] = "Only alphabet allowed for the other names field";
        }else{
            $sql = "SELECT * FROM tblstudent WHERE matricno = '$matric_no' ";
            $query_result = mysqli_query($conn, $sql);
            $result = mysqli_num_rows($query_result);
            if($result > 0){
                $_SESSION['ErrorMessage'] = "Matric No Already Exist";
            }else{

                $pass = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO tblstudent (matricno,surname,othername,gender,level,faculty,department,program,email,password,phone,address,image,status) VALUES('$matric_no','$surname','$othername','$gender','$level','$faculty','$department','$program','$email','$pass','N/A','N/A','default.png','Active') ";
                $query_result = mysqli_query($conn, $sql);

                if($query_result){
                    $_SESSION['SuccessMessage'] = "Account has been created successfully";

                    RedirectTo('index.php');
                }else{
                    $_SESSION['ErrorMessage'] = "Failed to create account";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
<section class="container-wrap">
    <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                  ?>
                  <div class="panel">
                      <div class="panel-header">
           	              <h4 class="panel-heading"><i class="fa fa-users"></i> Create An Account</h4>
                      </div> 
                      <form action="register.php" method="post">
                          <div class="panel-body">

                        <div class="form-body">
                            <span id="sprytextfield1">
                              <label for="Matric">Matric No</label>
                              <input type="text" name="matric_no" id="Matric" class="form-control">
                              <span class="textfieldRequiredMsg">Please enter your matric no.</span>
                            </span> 
                        </div>

                        <div class="form-body">
                            <span id="sprytextfield2">
                              <label for="Firstname">Surname</label>
                              <input type="text" name="surname" id="Firstname" class="form-control">
                              <span class="textfieldRequiredMsg">Please enter your first name.</span>
                            </span> 
                        </div>
                          
                        <div class="form-body">
                          <span id="sprytextfield3">
                            <label for="Othername">Other Names</label>
                            <input type="text" name="othername" id="Othername" class="form-control">
                          <span class="textfieldRequiredMsg">Please enter your other names.</span></span>
                        </div>
                        <div class="form-body">
                            <label for="department">Gender</label>
                            <select name="gender" class="form-control" id="gender">
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            ?>
                            </select>
                        </div>
                        <div class="form-body">
                            <label for="department">Level</label>
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

                        <div class="form-body">
                        <label for="faculty">Faculty</label>
                        <select name="faculty" class="form-control" id="faculty">
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

                        <div class="form-body">
                            <label for="department">Department</label>
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

                        <div class="form-body">
                          <label for="">Program</label>
                          <select name="program" class="form-control" id="program">
                            <option value="FT">FT</option>
                            <option value="DPP">DPP</option>
                            <option value="PT">PT</option>
                          </select>
                        </div>
                        
                        <div class="form-body">
                       	  <span id="sprytextfield4">
                          <label for="email">E-mail</label>
                          <input type="text" name="email" id="email" class="form-control">
                          <span class="textfieldRequiredMsg">Enter email address.</span><span class="textfieldInvalidFormatMsg">Invalid email format.</span></span> </div>                        
                        <div class="form-body">
                        <span id="sprypassword1">
                          <label for="password">Password</label>
                          <input type="password" name="password" id="password" class="form-control">
                        <span class="passwordRequiredMsg">Enter a password for your account.</span><span class="passwordMinCharsMsg">password must be more than six (6) characters.</span><span class="passwordMaxCharsMsg">Password must be less than 18 characters.</span></span> </div>
                      <div class="form-body">
                        <span id="spryconfirm1">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="form-control">
                      <span class="confirmRequiredMsg">Please confirm your password.</span><span class="confirmInvalidMsg">The password does not match your previous password.</span></span> </div>
                      <div class="form-body">
                        <span id="sprycheckbox1">
                        <input type="checkbox" name="policy" id="policy">
                        <label for="policy">Agress to our Policy</label>
                      <span class="checkboxRequiredMsg">Please make sure you agree to our policy.</span></span> </div>
                      
                    <div class="form-body">
                        <button type="submit" class="form-control btn btn-sm btn-primary" name="btn_register"><i class="fa fa-user-plus"></i> Sign up now</button>
                      </div>
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
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password", {validateOn:["blur", "change"]});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["blur", "change"]});
</script>

<script>
 /* function getDepartment(){
    var faculty = $('#faculty').val();
    $.ajax({
      url: "register.php",
      type: "POST",
      data: {faculty:faculty},
      success: function (result){
        $("#department").html(result);
      }
    })
  }*/
</script>
</body>

</html>