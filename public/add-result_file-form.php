<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;


$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$db->sql($sql_query);
$res_cur = $db->getResult();

if (isset($_POST['btnAdd'])) {
        $error = array();
        $date= $db->escapeString($fn->xss_clean($_POST['date']));
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
    

        // get image info


        

        if (empty($date)) {
            $error['date'] = " <span class='label label-danger'>Required!</span>";
        }
        if(empty($day)){
            $error['day'] = " <span class='label label-danger'>Required!</span>";
        }
        if(empty($time)){
            $error['time'] = " <span class='label label-danger'>Required!</span>";
        }
        if(empty($name)){
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if(empty($prize)){
            $error['prize'] = " <span class='label label-danger'>Required!</span>";
        }

        error_reporting(E_ERROR | E_PARSE);
       

       if(!empty($date) && !empty($day))
       {

        for ($i = 0; $i < count($_POST['name']); $i++) {
            $menu_image = $db->escapeString($_FILES['result_file']['name'][$i]);
            $image_error = $db->escapeString($_FILES['result_file']['error'][$i]);
            $image_type = $db->escapeString($_FILES['result_file']['type'][$i]);
            $extension = end(explode(".", $_FILES["result_file"]["name"][$i]));

                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['result_file']['name'][$i]);
                $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

                // upload new image
                $upload = move_uploaded_file($_FILES['result_file']['tmp_name'][$i], 'upload/results/' . $menu_image);

                // insert new data to menu table
                $upload_image = 'upload/results/' . $menu_image;
                $time = $db->escapeString($fn->xss_clean($_POST['time'][$i]));
                $name = $db->escapeString($fn->xss_clean($_POST['name'][$i]));
                $prize = $db->escapeString($fn->xss_clean($_POST['prize'][$i]));

                $sql = "INSERT INTO draw_resultfiles (date, day, time, name, prize,file,status) VALUES ('$date','$day','$time','$name','$prize','$upload_image',1)";
                $db->sql($sql);
                $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                  $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Draw Result Files Added Successfully</span>
                                                <h4><small><a  href='resultfiles.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Result Files</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    }
    
}
?>
<section class="content-header">
    <h1>Add Draw Result File</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
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
                    <h3 class="box-title">Add Draw Result File</h3>

                        <!--button for table-->
                           <a style="float:right;border-radius:10px;"class="btn btn-success" href="resultfiles.php">Manage Draw Result Files</a>
                     <!--/.button -->
                </div>

                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_draw_resultfile' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Date</label><i class="text-danger asterik">*</i><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                        <input type="date" class="form-control" name="date" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Draw Day</label><i class="text-danger asterik">*</i><?php echo isset($error['day']) ? $error['day'] : ''; ?>
                                        <input type="text" class="form-control" name="day" required />
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <br>
                
                        <div id="packate_div" >
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Draw Time</label><i class="text-danger asterik">*</i><?php echo isset($error['time']) ? $error['time'] : ''; ?>
                                        <select id='time' name="time[]" class='form-control'>
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
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Draw Name</label>
                                        <input type="text" class="form-control" name="name[]" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">First Prize</label><i class="text-danger asterik">*</i><?php echo isset($error['prize']) ? $error['prize'] : ''; ?>
                                        <input type="text" class="form-control" name="prize[]" required />
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class="form-group packate_div">
                                        <label  for="exampleInputFile">Upload Result Pdf</label><i class="text-danger asterik">*</i><?php echo isset($error['result_file']) ? $error['result_file'] : ''; ?>
                                        <input  class="form-control" type="file" name="result_file[]"  id="result_file" required />
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>
                                <div id="variations">
                                </div>
                            </div>

                        </div>
                    </div>
                       
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
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
    $('#add_draw_resultfile').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            day: "required",
            time: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row">'+'<div class="col-md-2"><div class="form-group"><label for="time">Draw Time</label>' + '<select id=time name="time[]" class="form-control"><option value="none">Select</option><?php
                                                            $sql = "SELECT * FROM `times`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['time'] ?>"><?= $value['time'] ?></option><?php } ?></select></div></div>' +'<div class="col-md-2"><div class="form-group"><label for="name">Draw Name</label>' + '<input type="text" class="form-control" name="name[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="prize">First Prize</label>' + '<input type="text" class="form-control" name="prize[]"></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="file">Upload Result Pdf</label>' + '<input type="file" class="form-control" name="result_file[]"></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>'); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>
<?php $db->disconnect(); ?>
