<?php
include_once('../includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;



$res = $db->getResult();
$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);

$res_cur = $db->getResult();
if (isset($_POST['btnAdd'])) {
        $error = array();
        $day = $db->escapeString($fn->xss_clean($_POST['day']));
        if (empty($day)) {
            $error['day'] = " <span class='label label-danger'>Required!</span>";
        }
        for ($i = 0; $i < count($_POST['name']); $i++) {
                $name = $db->escapeString($fn->xss_clean($_POST['name'][$i]));
                $time = $db->escapeString($fn->xss_clean($_POST['time'][$i]));
                $sql = "INSERT INTO draw_result (day,name,time) VALUES ('$day','$name','$time')";
                $db->sql($sql);
                $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                  $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Draw Result Added Successfully</span>
                                                <h4><small><a  href='draw_results.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Results</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    
}
?>
<section class="content-header">
    <h1>Add Draw Result</h1>
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
                    <h3 class="box-title">Add Draw Result</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_draw_result' method="post" enctype="multipart/form-data">
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
                                                  <option value='<?= $value['day'] ?>'><?= $value['day'] ?></option>
                                        <?php } ?>
                                     </select>
                                </div>
                            </div>  
                        </div>
                        <br>
                
                        <div id="packate_div"  >
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Draw Name</label> 
                                        <input type="text" class="form-control" name="name[]" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Draw Time</label>
                                        <select id='time' name="time[]" class='form-control' required>
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
    $('#add_draw_result').validate({

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
                $(wrapper).append('<div class="row"><div class="col-md-4"><div class="form-group"><label for="name">Draw Name</label>' + '<input type="text" class="form-control" name="name[]" required></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="time">Draw Time</label>' + '<select id=time name="time[]" class="form-control" required><option value="none">Select</option><?php
                                                            $sql = "SELECT * FROM `times`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['time'] ?>"><?= $value['time'] ?></option><?php } ?></select></div></div>' +'<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>'); //add input box
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