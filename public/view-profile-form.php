<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<section class="content-header">
    <h1>View Profile</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="view-profile.php" class=" btn btn-primary"> About</a>
                        <a href="admin-profile.php" class="btn btn-default"> Setting</a>
                        
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <?php
                            $sql = "SELECT * FROM admin WHERE id = 1";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows();
                            if($num >= 1){

                                $sql = "SELECT * FROM admin WHERE id = 1";
                                $db->sql($sql);
                                $res = $db->getResult();
                                ?>
                                <tr>
                                    <th style="width: 200px">ID</th>
                                    <td><?php echo $res[0]['id'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Name</th>
                                    <td><?php echo $res[0]['name'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Email</th>
                                    <td><?php echo $res[0]['email'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Mobile Number</th>
                                    <td><?php echo $res[0]['phone'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Address</th>
                                    <td><?php echo $res[0]['address'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Profile Image</th>
                                    <td><?php  echo $res[0]['image'] ?></td>
                                </tr>
                        <?php
                            }
                            else{
                                echo "No Record Found";
                            }
                            ?>
                            <hr>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="home.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

