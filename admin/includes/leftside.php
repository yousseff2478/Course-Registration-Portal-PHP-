<div class="gist-status">
    <div class="status-head">
        <h5>Welcome <?php echo $_SESSION['username']; ?></h5>
        <h6>Admin</h6>
    </div>
</div>
<div class="gist-status">
    <div class="media status-head">
        <div class="media-left">
            <a><img class="img-circle status-image" src="uploads/admin_pic/<?php echo $_SESSION['picture']; ?>" width="70" height="70"></a>
        </div>
        <div class="media-body">
            <div class="follow-head">
                <div class="col-sm-12">
                    <h4><?php echo $_SESSION['fullname']; ?></h4>
                    <p class="text-left text-muted status-text"><?php echo $_SESSION['email']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="gist-status">
    <ul>
        <h4>Actions</h4>
        <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashbaord</li></a>
        <a href="add_record.php"><li><i class="fa fa-plus"></i> Add Records</li></a>
        <a href="edit_record.php"><li><i class="fa fa-edit"></i> View Records</li> </a>
        <a href="add_courses.php"><li><i class="fa fa-plus"></i> Add Courses</li></a>
        <a href="semester.php"><li><i class="fa fa-plus"></i> Semester/Session</li></a>
        <a href="profile.php"><li><i class="fa fa-user"></i> Profile</li> </a>
        <a href="report.php"><li><i class="fa fa-folder"></i> Student Records</li> </a>
        <a href="create_user.php"><li><i class="fa fa-lock"></i> Create Account</li> </a>
        <a href="logout.php"><li><i class="fa fa-sign-out"></i> Logout</li> </a>
    </ul>
</div>