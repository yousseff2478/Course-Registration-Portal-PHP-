<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_POST['btn_login'])){
        $matric_no = $_POST['matric_no'];
        $password = $_POST['password'];

        $matric_no = mysqli_real_escape_string($conn, $matric_no);
        $password = mysqli_real_escape_string($conn, $password);

        if(empty($matric_no) || empty($password)){
            $_SESSION['ErrorMessage'] = "All fields are required";
        }else{
            $sql = "SELECT * FROM tblstudent WHERE matricno = '$matric_no' AND status = 'Active' ";
            $query_result = mysqli_query($conn, $sql);
            $result = mysqli_num_rows($query_result);
            if($result > 0){
                while($row = mysqli_fetch_array($query_result)){
                  $_fetchedpassword = $row['password'];
                  $_SESSION['matricno'] = $row['matricno'];
                  $_SESSION['surname'] = $row['surname'];
                  $_SESSION['othername'] = $row['othername'];
                  $_SESSION['level'] = $row['level'];
                  $_SESSION['faculty'] = $row['faculty'];
                  $_SESSION['department'] = $row['department'];
                  $_SESSION['program'] = $row['program'];
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['picture'] = $row['image'];
                }

                if(password_verify($password, $_fetchedpassword))
                {
                  RedirectTo('dashboard.php');
                }else{
                  $_SESSION['ErrorMessage'] = "Matric No/Password is incorrect";
                }
            }else{
                $_SESSION['ErrorMessage'] = "Your account has been deactivated, please contact the admin to resolve the issue. Thank You!";
            }
        }
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <?php include_once('includes/styles.html'); ?>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
<section class="container-wrap">
    <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="panel">
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?>
                      <div class="panel-header">
           	              <h4 class="panel-heading"><i class="fa fa-sign-in"></i> Login</h4>
                      </div> 
                      <form action="index.php" method="POST">
                        <div class="panel-body">
                          <div class="form-body">
                         	  <span id="sprytextfield1">
                            <label for="matric_no">Matric No</label>
                            <input type="text" name="matric_no" id="matric_no" class="form-control">
                            <span class="textfieldRequiredMsg">Enter your matric no.</span></span> 
                          </div>                        
                          <div class="form-body">
                            <span id="sprytextfield2">
                              <label for="password">Password</label>
                              <input type="password" name="password" id="password" class="form-control">
                              <span class="textfieldRequiredMsg">Enter your password.</span>
                            </span>
                          </div>                    
                          <div class="form-body">
                            <button type="submit" class="form-control btn btn-sm btn-primary" name="btn_login"><i class="fa fa-sign-in"></i>  Login</button>
                          </div>
                        </div>
                      </form>
                      <hr>
                      <div class="panel-footer">
                        <div class="form-body">
                          <a href="forget_password.php" class="btn btn-sm btn-warning">Forget Password?</a>
                          <a href="register.php" class="pull-right btn btn-sm btn-success">Create An Account</a>
                        </div>
                      </div>
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
</script>
</body>

</html>