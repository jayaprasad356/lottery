<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();

$sql_query = "SELECT * FROM claim WHERE id = 1";
$db->sql($sql_query);
$res= $db->getResult();

if (isset($_POST['btnAdd'])) {
        
       

			if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
                if (!empty($old_image)) {
					unlink($old_image);
				}
				$upload_image = 'upload/images/' . $filename;
				$sql = "UPDATE claim SET `image`='" . $upload_image . "' WHERE id = 1";
				$db->sql($sql);
                $update_result = $db->getResult();
                if (!empty($update_result)) {
                    $update_result = 0;
                } else {
                    $update_result = 1;
                }
                if ($update_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                     <span class='label label-success'>Success! Claim From Image Updated..</span>
                                                      </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }
        }
    }
?>
<section class="content-header">
    <h1>Claim From Image</h1>
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
                <form id='modal_form'  method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <input type="hidden" id="old_image" name="old_image"  value="<?= $res[0]['image']; ?>">
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Claim From Image</label>
                                        <input class="form-control" type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        
                                        <div class="col-md-6">
                                                <p class="help-block"><img id="blah" src="<?php echo $res[0]['image']; ?>" style="max-width:100%" /></p>
                                       </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        
                        </div><!--/.box-body -->
                      
                        <div class="box-footer">
                            <button type="submit" name="btnAdd" class="btn btn-primary">Submit</button>
                            <!-- <input type="reset" class="btn-warning btn" name="btnClear" value="Clear" /> -->
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
    $('#modal_form').validate({

        ignore: [],
        debug: false,
        rules: {
           image:"required",
  
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
<script>
    window.location('claim.php');
</script>
