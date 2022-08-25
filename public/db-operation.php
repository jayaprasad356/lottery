<?php
session_start();
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
$auth_username = $db->escapeString($_SESSION["user"]);

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/functions.php');
$function = new functions;


if (isset($_POST['drawtime'])) {
    $day = $db->escapeString($fn->xss_clean($_POST['day']));
    $time = $db->escapeString($fn->xss_clean($_POST['time']));
    $sql = "SELECT * FROM draw_result WHERE day = '$day' AND time = '$time'";
    $db->sql($sql);
    $res = $db->getResult();
    if (!empty($res)) {
        foreach ($res as $row) {
            echo "<option value=" . $row['name'] . ">" . $row['name'] . "</option>";
        }
    } else {
        echo "<option value=''></option>";
    }
    return false;

}

