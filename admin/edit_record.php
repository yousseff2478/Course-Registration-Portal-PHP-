<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){
        if(isset($_POST['delete_level'])){
            $level = $_POST['del_level'];

            $level = mysqli_real_escape_string($conn, $level);

            $sql = "DELETE FROM tbllevel WHERE name = '$level' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "Level removed successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to remove level";
            }
        }else if(isset($_POST['delete_faculty'])){
            $faculty = $_POST['del_faculty'];

            $faculty = mysqli_real_escape_string($conn, $faculty);
            
            $sql = "DELETE FROM tblfaculty WHERE name = '$faculty' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "Faculty removed successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to remove faculty";
            }
        }else if(isset($_POST['delete_department'])){
            $department = $_POST['del_department'];

            $department = mysqli_real_escape_string($conn, $department);

            $sql = "DELETE FROM tbldepartment WHERE department = '$department' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
                $_SESSION['SuccessMessage'] = "Department removed successfully";
            }else{
                $_SESSION['ErrorMessage'] = "Failed to remove department";
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

                <!-- Level Record -->
                <div class="col-md-8 col">
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?>
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Level Records <small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999;">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Level </th>
                                                <th>Delete </th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbllevel ORDER BY name ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($row = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <form action="edit_record.php" method="POST">
                                                        <input type="hidden" name="del_level" value="<?php echo $row['name']; ?>">
                                                        <span style="color: red; font-size: 16px;">
                                                        <button class="btn btn-danger btn-sm" type="submit" name="btn_delete" onclick="return confirm('Delete this Record?')"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Faculty Record -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Faculty Records <small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Faculty Name</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tblfaculty ORDER BY name ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($row = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><form action="edit_record.php" method="POST">
                                                    <input type="hidden" name="del_faculty" value="<?php echo $row['name']; ?>">
                                                    <span style="color: red; font-size: 16px;"><button type="submit" class="btn btn-danger btn-sm" name="delete_faculty" onclick="return confirm('Delete this Record?')"><i class="fa fa-trash"></i></span></button>
                                                </form></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Level Record -->
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Department Records <small><a href="dashboard.php"><span class="pull-right"><i class="fa fa-arrow-left"></i>   Back</span></a></small></h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Department </th>
                                                <th>Delete </th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM tbldepartment ORDER BY department ASC";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($row = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['department']; ?></td>
                                                <form action="edit_record.php" method="POST">
                                                    <input type="hidden" name="del_department" value="<?php echo $row['department']; ?>">
                                                    <td><span style="color: red; font-size: 16px;"><button type="submit" name="delete_department" class="btn btn-danger btn-sm" onclick="return confirm('Delete this Record?')"><i class="fa fa-trash"></i></span></button></td>
                                                </form>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }
                                        }
                                        ?>
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
</script>
</body>

</html>