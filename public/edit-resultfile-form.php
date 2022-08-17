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
$sql="SELECT * FROM draw_resultfiles WHERE id='$ID'";
$db->sql($sql);
$res = $db->getResult();

if (isset($_POST['btnUpdate'])) {
        $error = array();
        $date = $db->escapeString($fn->xss_clean($_POST['date']));
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
        $time = $db->escapeString($fn->xss_clean($_POST['time']));
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $prize = $db->escapeString($fn->xss_clean($_POST['prize']));

        // get image info
        $menu_image = $db->escapeString($_FILES['result_file']['name']);
        $image_error = $db->escapeString($_FILES['result_file']['error']);
        $image_type = $db->escapeString($_FILES['result_file']['type']);

        
        if(empty($date)){
            $error['date'] = "Please enter date";
        }
        if(empty($day)){
            $error['day'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($time)) {
            $error['time'] = " <span class='label label-danger'>Required!</span>";
        }
        if(empty($prize)){
            $error['prize'] = " <span class='label label-danger'>Required!</span>";
        }

        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["result_file"]["name"]));

        if ( !empty($name) && !empty($time) && !empty($day) && !empty($prize) && !empty($date)) {
             // create random image file name
             $string = '0123456789';
             $file = preg_replace("/\s+/", "_", $_FILES['result_file']['name']);
             $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

             // upload new image
             $upload = move_uploaded_file($_FILES['result_file']['tmp_name'], 'upload/results/' . $menu_image);

             // insert new data to menu table
             $upload_image = 'upload/results/' . $menu_image;
            $sql = "UPDATE draw_resultfiles SET date='$date',day ='$day',name='$name',time='$time',prize='$prize',file='$upload_image' WHERE id = '$ID'";
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                $error['update_menu'] = "<section class='content-header'>
                                                 <span class='label label-success'>Draw Result File Updated Successfully</span>
                                                 <h4><small><a  href='resultfiles.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Results</a></small></h4>
                                                  </section>";
            } else {
                $error['update_menu'] = " <span class='label label-danger'>Failed</span>";
            }
        }
}

$data = array();

$sql_query = "SELECT * FROM `draw_resultfiles` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
    <h1>Edit Draw Result File</h1>
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
                    <h3 class="box-title">Edit Draw Result File</h3>

                     <!--button for table-->
                         <a style="float:right;border-radius:10px;"class="btn btn-success" href="resultfiles.php">Manage Draw Result Files</a>
                     <!--/.button -->

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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Draw Date</label><i class="text-danger asterik">*</i><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                            <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date']?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Draw Day</label><i class="text-danger asterik">*</i><?php echo isset($error['day']) ? $error['day'] : ''; ?>
                                            <input type="text" class="form-control" name="day" value="<?php echo $res[0]['day']?>" />
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Time</label><i class="text-danger asterik">*</i><?php echo isset($error['time']) ? $error['time'] : ''; ?>
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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">First Prize</label>
                                        <input type="text" class="form-control" name="prize" value="<?php echo $res[0]['prize']?>" required />
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class="form-group packate_div">
                                        <label  for="exampleInputFile">Upload Result Pdf</label>
                                        <input  class="form-control" type="file" name="result_file"  id="result_file" value="<?php echo $res[0]['file']?>" />
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