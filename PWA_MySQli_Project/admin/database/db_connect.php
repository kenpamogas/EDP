<?php  
$host = 'localhost';  
$username = 'root';  
$password = '';
$dbname = 'customer';
$connection = mysqli_connect($host, $username, $password, $dbname);  
if(! $connection )  
{  
    die('Database Connection failed: ' . mysqli_connect_error());  
}  
?>