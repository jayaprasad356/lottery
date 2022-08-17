<?php


if (isset($_POST['btnLogin'])) {

    $email = $db->escapeString($_POST['email']);
    $password = $db->escapeString($_POST['password']);

    $currentTime = time() + 25200;
    $expired = 3600;

    $error = array();

    if (empty($email)) {
        $error['email'] = " <span class='label label-danger'>Mobile should be filled!</span>";
    }

    if (empty($password)) {
        $error['password'] = " <span class='label label-danger'>Password should be filled!</span>";
    }
    if (!empty($email) && !empty($password)) {

        $sql_query = "SELECT * FROM admin WHERE email = '" . $email . "' AND password = '" . $password . "'";

        $db->sql($sql_query);

        $res = $db->getResult();
        $num = $db->numRows($res);

        if ($num == 1) {
            
            header("location:home.php");

            
        } else {
            $error['failed'] = "<span class='btn btn-danger'>Invalid Email or Password!</span>";
        }
    }


        
    }
?>
<div class="col-md-4 col-md-offset-4 " style="margin-top:80px;">
    <div class='row'>
        <div class="col-md-12 text-center">
            <img src="dist/img/logo.png" height="110">
            
        </div>
        
        <div class="box box-info col-md-12 ">
            <div class="box-header with-border ">
                <h3 class="box-title">Singapore Lottary Admin Login</h3>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email :</label><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                        <input type="text" name="email" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password :</label><?php echo isset($error['password']) ? $error['password'] : ''; ?>
                        <input type="text" class="form-control" name="password" value=""><br>
                    </div>
                    <center><?php echo isset($error['failed']) ? $error['failed'] : ''; ?></center>
                    <center><?php echo isset($error['failed_status']) ? $error['failed_status'] : ''; ?></center>
                    <div class="box-footer">
                        <button type="submit" name="btnLogin" class="btn btn-info pull-left">Login</button>
                    </div>
                    <div class="box-footer">
                        <a href="#" class="btn pull-left">Forgot Password?</a>
                        <!-- <a href="forgot-password.php" class="btn pull-right">Forgot password?</a> -->

                    </div>
                
                   
            </form>
        </div>
    </div>
</div>
</div>
