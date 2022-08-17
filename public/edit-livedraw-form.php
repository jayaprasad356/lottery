<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}

$sql="SELECT * FROM live_draw WHERE id='$ID'";
$db->sql($sql);
$res = $db->getResult();
if (isset($_POST['btnUpdate'])) {
        $error = array();
        $date = $db->escapeString($fn->xss_clean($_POST['date']));
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
        $time = $db->escapeString($fn->xss_clean($_POST['time']));
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $link = $db->escapeString($fn->xss_clean($_POST['link']));
       
    
        if(empty($date)){
            $error['date'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($day)) {
            $error['day'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($time)) {
            $error['time'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($link)) {
            $error['link'] = " <span class='label label-danger'>Required!</span>";
        }


        if ( !empty($date) && !empty($name) && !empty($time) && !empty($day) && !empty($link) ) {
            $sql = "UPDATE live_draw SET date='$date',day ='$day',time='$time',name='$name',link='$link' WHERE id = '$ID'";
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                $error['update_menu'] = "<section class='content-header'>
                                                 <span class='label label-success'>Live Draw Updated Successfully</span>
                                                 <h4><small><a  href='livedraws.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Draws</a></small></h4>
                                                  </section>";
            } else {
                $error['update_menu'] = " <span class='label label-danger'>Failed</span>";
            }
        }
}

$data = array();

$sql_query = "SELECT * FROM `live_draw` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
    <h1>Edit Draw</h1>
    <?php echo isset($error['update_menu']) ? $error['update_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Draw</h3>

                     <!---button for table -->
                     <a style="float:right;border-radius:10px;"class="btn btn-success" href="livedraws.php">Manage Draw</a>



                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_draw_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                           <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Date</label> 
                                        <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date']?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Day</label> 
                                        <input type="text" class="form-control" name="day" value="<?php echo $res[0]['day']?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Time</label>
                                        <select id='time' name="time" class='form-control' required>
                                            <option value="none">Select Timeslot</option>
                                                <?php
                                                $sql = "SELECT * FROM `times`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                   <option value='<?= $value['time'] ?>' <?=$res[0]['time'] == $value['time'] ? ' selected="selected"' : '';?>><?= $value['time'] ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <br>
                        <div class="row">
                        <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Name</label> 
                                        <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Live Draw</label> 
                                        <input type="text" class="form-control" name="link" value="<?php echo $res[0]['link']?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                               

                </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>