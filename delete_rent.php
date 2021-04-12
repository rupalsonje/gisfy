<?php
include('db_connect.php');

$id = $_GET['id'];

$del = mysqli_query($conn,"DELETE FROM `rent data` where id = '$id'");

if($del)
{
    mysqli_close($conn);
    header("location:rent.php");
}
else
    echo "Error deleting record";
?>