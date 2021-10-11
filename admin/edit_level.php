<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        if(isset($_POST['update_level'])){
            $level = $_POST['level'];
            $id = $_POST['id'];

            $level = mysqli_real_escape_string($conn, $level);
            
            if(empty($level)){
                $_SESSION['ErrorMessage'] = "Please Enter a Valid Level";
            }else{
                $sql = "SELECT * FROM tbllevel WHERE name = '$level' ";
                $query_result = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query_result);
                if($result > 0){
                    $_SESSION['ErrorMessage'] = "Level Already Exist";
                }else{
                    $sql = "UPDATE tbllevel SET name = '$level' WHERE name = '$id' ";
                    $query_result = mysqli_query($conn, $sql);

                    if($query_result){
                        $_SESSION['SuccessMessage'] = "Level updated successfully";
                        RedirectTo('edit_record.php');
                    }else{
                        $_SESSION['ErrorMessage'] = "Failed to update level";
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
                            <h4>Edit Level<small><a href="edit_record.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="form-group">
                                <form action="edit_level.php" method="POST">
                                    <?php
                                        if(isset($_GET['id'])){
                                            $level = $_GET['id'];
                                            $sql = "SELECT * FROM tbllevel WHERE name = '$level' ";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($row = mysqli_fetch_array($query_result)){
                                                    $name = $row['name'];
                                    ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="hidden" name="id" value="<?php echo $name; ?>">
                                            <input class="form-control" type="text" name="level" placeholder="Type new Level name...." value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="form-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" name="update_level"><i class="fa fa-plus"></i>Update Level</button>
                                        </div>
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