<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



$res = $db->getResult();
$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$db->sql($sql_query);

$res_cur = $db->getResult();
if (isset($_POST['btnAdd'])) {
        $error = array();
        $date = $db->escapeString($fn->xss_clean($_POST['date']));
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
        $time = $db->escapeString($fn->xss_clean($_POST['time']));
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $link = $db->escapeString($fn->xss_clean($_POST['link']));
       
        if (empty($date)) {
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

     if(!empty($date) && !empty($day) && !empty($time) && !empty($name) && !empty($link)){
             
            $sql = "INSERT INTO live_draw (date,day,time,name,link) VALUES ('$date','$day','$time','$name','$link')";
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                  $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Draw Added Successfully</span>
                                                <h4><small><a  href='livedraws.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Live Draw</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    
}
?>
<section class="content-header">
    <h1>Add Draw</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <br>


</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Draw Result</h3>

                    <!--button for table-->
                       <a style="float:right;border-radius:10px;"class="btn btn-success" href="livedraws.php">Manage Draw</a>
                     <!--/.button -->
                     
                    </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_draw' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Date</label> 
                                        <input type="date" class="form-control" name="date" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Day</label> 
                                        <input type="text" class="form-control" name="day" required />
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
                                                    <option value='<?= $value['time'] ?>'><?= $value['time'] ?></option>
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
                                        <input type="text" class="form-control" name="name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Live Draw</label> 
                                        <input type="text" class="form-control" name="link" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                       
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Submit" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Reset" id="btnClear" />
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
<script>
    $('#add_draw').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            day: "required",
            time: "required",
            date: "required",
            link: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<?php $db->disconnect(); ?>