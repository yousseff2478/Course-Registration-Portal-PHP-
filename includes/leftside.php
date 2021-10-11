<div class="gist-status">
    <div class="media status-head">
        <div class="media-left">
            <?php if($_SESSION['picture'] != "default.png"): ?>
                <a><img class="img-circle status-image" src="images/profile_pic/<?php echo $_SESSION['picture']; ?>" width="70" height="70"></a>
            <?php else: ?>
                <a><img class="img-circle status-image" src="images/pic/<?php echo $_SESSION['picture']; ?>" width="70" height="70"></a>
            <?php endif; ?>
        </div>
        <div class="media-body">
            <div class="follow-head">
                <div class="col-sm-12">
                    <h4><?php echo $_SESSION['surname'] ." ". $_SESSION['othername']; ?></h4>
                    <p class="text-left text-muted status-text"><?php echo $_SESSION['faculty']; ?></p>
                    <p class="text-left text-muted status-text"><?php echo $_SESSION['department']; ?></p>
                    <p class="text-left text-muted status-text"><?php echo $_SESSION['level']." - ".$_SESSION['program']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="gist-status">
    <ul>
        <h4>Actions</h4>
        <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashbaord</li></a>
        <a href="courses.php"><li><i class="fa fa-book"></i> Register Courses</li></a>
        <a href="profile.php"><li><i class="fa fa-user"></i> Profile</li> </a>
        <a href="logout.php"><li><i class="fa fa-sign-out"></i> Logout</li> </a>
    </ul>
</div>