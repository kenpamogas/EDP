<?php
if(isset($_POST['signup'])){
date_default_timezone_set('Etc/GMT-8');
require_once('../database/db_connect.php');

$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
$Email = $_POST['Email'];
$Password = md5($_POST['Password']);
$Reg_DateTime = date("Y-m-d h:i:s");

 //check if email is existing
 $check_email = mysqli_query($connection, "SELECT * FROM tbl_users where Email='$Email'");
 if(mysqli_num_rows($check_email) >= 1){
    echo "<script>window.location.href='..?page=signup&exist=1';</script>";
 }


else{


$query = "INSERT INTO tbl_users(Firstname, Lastname, Email, Password, Reg_DateTime, Gender, DoB, ContactNo, Address) VALUES ('$Firstname','$Lastname','$Email','$Password','$Reg_DateTime', 'default_gender', 'DoB', 'ContacNo', 'Address')";


if(mysqli_query($connection,$query)){
    echo "<script>window.location.href='..?page=login&success=1';</script>";
}

else{
    echo "<script>window.location.href='..?page=signup&error=1';</script>";
}
}
}
?>