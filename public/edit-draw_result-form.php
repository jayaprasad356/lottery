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
$sql="SELECT * FROM draw_result WHERE id='$ID'";
$db->sql($sql);
$res = $db->getResult();
if (isset($_POST['btnUpdate'])) {
        $error = array();
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $time = $db->escapeString($fn->xss_clean($_POST['time']));
    
        if(empty($day)){
            $error['day'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($time)) {
            $error['time'] = " <span class='label label-danger'>Required!</span>";
        }

        if ( !empty($name) && !empty($time) && !empty($day) ) {
            $sql = "UPDATE draw_result SET day ='$day',name='$name',time='$time' WHERE id = '$ID'";
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                $error['update_menu'] = "<section class='content-header'>
                                                 <span class='label label-success'>Draw Result Updated Successfully</span>
                                                 <h4><small><a  href='draw_results.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Results</a></small></h4>
                                                  </section>";
            } else {
                $error['update_menu'] = " <span class='label label-danger'>Failed</span>";
            }
        }
}

$data = array();

$sql_query = "SELECT * FROM `draw_result` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
    <h1>Edit Draw Result</h1>
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
                    <h3 class="box-title">Edit Draw Result</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_draw_result_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-8'>
                                    <label for="exampleInputEmail1">Draw Day</label> <i class="text-danger asterik">*</i> <?php echo isset($error['day']) ? $error['day'] : ''; ?><br>
                                    <select id='day' name="day" class='form-control' required>
                                        <option value="none">Select</option>
                                            <?php
                                            $sql = "SELECT * FROM `days`";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
                                               <option value='<?= $value['day'] ?>' <?=$res[0]['day'] == $value['day'] ? ' selected="selected"' : '';?>><?= $value['day'] ?></option>

                                        <?php } ?>
                                     </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Name</label> 
                                        <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group packate_div">
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
                               

                </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                        <!-- <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" /> -->
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>