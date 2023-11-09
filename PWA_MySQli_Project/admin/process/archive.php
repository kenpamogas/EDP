<?php

require_once('../database/db_connect.php');

$id = $_REQUEST['id'];

// Use prepared statements to prevent SQL injection
$query_select = "SELECT id, Firstname, Lastname, Email, Password, Reg_DateTime, Gender, ContactNo, DoB, Address, Updation_Date FROM tbl_users WHERE id=?";
$select_statement = mysqli_prepare($connection, $query_select);
mysqli_stmt_bind_param($select_statement, "i", $id);
mysqli_stmt_execute($select_statement);
mysqli_stmt_store_result($select_statement);

// Check if the record exists before proceeding
if (mysqli_stmt_num_rows($select_statement) > 0) {
    // The record exists, fetch the data
    mysqli_stmt_bind_result($select_statement, $id, $Firstname, $Lastname, $Email, $Password, $Reg_DateTime, $Gender, $ContactNo, $DoB, $Address, $Updation_Date);
    mysqli_stmt_fetch($select_statement);

    // Check if 'Gender' is not NULL or empty
    if ($Gender !== null && $Gender !== "") {
        // Now, insert into tbl_archive
        $query_insert = "INSERT INTO tbl_archive (id, Firstname, Lastname, Email, Password, Reg_DateTime, Gender, ContactNo, DoB, Address, Updation_Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_statement = mysqli_prepare($connection, $query_insert);
        mysqli_stmt_bind_param($insert_statement, "issssssssss", $id, $Firstname, $Lastname, $Email, $Password, $Reg_DateTime, $Gender, $ContactNo, $DoB, $Address, $Updation_Date);
        
        // Execute the insert statement
        if (mysqli_stmt_execute($insert_statement)) {
            // Now, delete from tbl_users
            $query_delete = "DELETE FROM tbl_users WHERE id=?";
            $delete_statement = mysqli_prepare($connection, $query_delete);
            mysqli_stmt_bind_param($delete_statement, "i", $id);
            
            // Execute the delete statement
            if (mysqli_stmt_execute($delete_statement)) {
                echo "<script>window.location.href='..?page=home&success=1';</script>";
            } else {
                echo "<script>window.location.href='..?page=home&error=2&message=" . mysqli_error($connection) . "';</script>";
            }
        } else {
            echo "<script>window.location.href='..?page=home&error=1&message=" . mysqli_error($connection) . "';</script>";
        }
    } else {
        // Handle the case where 'Gender' is NULL or empty
        echo "<script>window.location.href='..?page=home&error=4';</script>";
    }
} else {
    // Record not found
    echo "<script>window.location.href='..?page=home&error=3';</script>";
}

// Close the prepared statements
mysqli_stmt_close($select_statement);
mysqli_stmt_close($insert_statement);
mysqli_stmt_close($delete_statement);
mysqli_close($connection);
?>