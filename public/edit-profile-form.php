<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



$sql="SELECT * FROM admin WHERE id=1";
$db->sql($sql);
$res = $db->getResult();

if (isset($_POST['btnUpdate'])) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $email = $db->escapeString($fn->xss_clean($_POST['email']));
        $address = $db->escapeString($fn->xss_clean($_POST['address']));
        $phone = $db->escapeString($fn->xss_clean($_POST['phone']));
        $password = $db->escapeString($fn->xss_clean($_POST['password']));
       
    
        if(empty($name)){
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($phone)) {
            $error['phone'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($password)) {
            $error['password'] = " <span class='label label-danger'>Required!</span>";
        }


        if ( !empty($name) && !empty($email) && !empty($address) && !empty($phone) && !empty($password) ) {
            if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'dist/img/';
				
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
				$upload_image = 'dist/img/' . $filename;
				$sql = "UPDATE admin SET `image`='" . $upload_image . "'  WHERE id = 1";
				$db->sql($sql);
			}
           
            $sql_query = "UPDATE admin SET name='$name',email='$email',address='$address',phone='$phone',password='$password' WHERE id = 1";
            $db->sql($sql_query);
            $update_result = $db->getResult();
           if (!empty($update_result)) {
               $update_result = 0;
           } else {
               $update_result = 1;
           }

           // check update result
           if ($update_result == 1) {
               $error['update_profile'] = " <section class='content-header'><span class='label label-success'>Profile updated Successfully</span></section>";
           } else {
               $error['update_profile'] = " <span class='label label-danger'>Failed</span>";
           }
       }
   } 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM admin WHERE id =1";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
            
    <?php echo isset($error['update_profile']) ? $error['update_profile'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Profile</h3>
                    <a style="float:right;" href="view-profile.php" class=" btn btn-default"> About</a>
                    <a style="float:right;" href="admin-profile.php" class="btn btn-primary"> Setting</a>
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
                                        <label for="exampleInputEmail1">Name</label> 
                                        <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label> 
                                        <input type="text" class="form-control" name="email" value="<?php echo $res[0]['email']?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label> 
                                        <input type="text" class="form-control" name="address" value="<?php echo $res[0]['address']?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number</label> 
                                        <input type="number" class="form-control" name="phone" value="<?php echo $res[0]['phone']?>" />
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputFile"> Profile Image</label>
                                        
                                        <input class="form-control" type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image']; ?>" style="height:100px;max-width:100%" /></p>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Old Password</label> 
                                        <input type="password" class="form-control" name="old_password" value="<?php echo $res[0]['password']?>" readonly />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">New Password</label> 
                                        <input type="text" class="form-control" name="password"  value="<?php echo $res[0]['password']?>" />
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