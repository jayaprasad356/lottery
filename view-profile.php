<?php
	session_start();
	// set time for session timeout
	$currentTime = time() + 25200;
	$expired = 3600;
	

	
	
	// destroy previous session timeout and create new one
	unset($_SESSION['timeout']);
	$_SESSION['timeout'] = $currentTime + $expired;
?>
<?php include "header.php";?>
<html>
<head>
<title>View |- Profile</title>
<style>
    .asterik {
    font-size: 20px;
    line-height: 0px;
    vertical-align: middle;
}
</style>
</head>
</body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php include('public/view-profile-form.php'); ?>
      </div><!-- /.content-wrapper -->
  </body>
</html>
<?php include "footer.php";?>