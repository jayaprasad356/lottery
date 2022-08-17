<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();

$sql_query = "SELECT * FROM about_us WHERE id = 1";
$db->sql($sql_query);
$res= $db->getResult();

if (isset($_POST['btnAdd'])) {
        $error = array();
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
    
        
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if (!empty($description)) {
                $sql = "UPDATE about_us SET description='$description' WHERE id=1";
                $db->sql($sql);
                $update_result = $db->getResult();
                if (!empty($update_result)) {
                    $update_result = 0;
                } else {
                    $update_result = 1;
                }
                if ($update_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                     <span class='label label-success'>About Us Updated Successfully</span>
                                                      </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }
        }
    }

$sql="SELECT * FROM about_us WHERE id = 1";
$db->sql($sql);
$res= $db->getResult();

?>
<section class="content-header">
    <h1>About Us</h1>
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
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='about_us_form'  method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row"> 
                            <div class="col-md-10">
                                <div class="form-group">
                                        <label for="description">About Us :</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                        <textarea name="description" id="description" class="form-control" rows="8" <?php echo $res[0]['description']; ?>></textarea>
                                        <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('description');
                                       </script>
                                </div> 
                            </div>
                        </div>
                        <br>
                        
                        </div><!--/.box-body -->
                      
                        <div class="box-footer">
                            <button type="submit" name="btnAdd" value="Submit" class="btn btn-primary">Submit</button>
                            <input type="reset" class="btn-warning btn" value="Reset" name="btnClear" value="Clear" />
                        </div>
                
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');
</script>

<script>
    $('#about_us_form').validate({

        ignore: [],
        debug: false,
        rules: {
                      description: {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                }
            },
  
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
