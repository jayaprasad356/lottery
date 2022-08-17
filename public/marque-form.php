<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();

$sql_query = "SELECT * FROM marque WHERE id = 1";
$db->sql($sql_query);
$res= $db->getResult();

if (isset($_POST['btnAdd'])) {
        $error = array();
        $home_marque = $db->escapeString($fn->xss_clean($_POST['home_marque']));
    
        
        if (empty($home_marque)) {
            $error['home_marque'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if (!empty($home_marque)) {
                $sql = "UPDATE marque SET home_marque='$home_marque',status=1 WHERE id=1";
                $db->sql($sql);
                $update_result = $db->getResult();
                if (!empty($update_result)) {
                    $update_result = 0;
                } else {
                    $update_result = 1;
                }
                if ($update_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                     <span class='label label-success'>Home Page Marque Updated Successfully</span>
                                                      </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }
        }
    }
?>
<section class="content-header">
    <h1>Home Page Marque</h1>
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
                <form id='marque_form'  method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-8'>
                                
                                    <label for="exampleInputEmail1">Home Page Marque</label><?php echo isset($error['home_marque']) ? $error['home_marque'] : ''; ?>
                                    <input type="text" class="form-control" name="home_marque" value="<?php echo $res[0]['home_marque']; ?>">
						        </div>
                            </div>
                        </div>
                        <br>
                       
                            <div class="box-footer">
                                <button type="submit" name="btnAdd" class="btn btn-primary">Submit</button>
                                <input type="reset" class="btn-warning btn" name="btnClear" value="Clear" />
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
    $('#marque_form').validate({

        ignore: [],
        debug: false,
        rules: {
            home_marque:"required",
  
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
