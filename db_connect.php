<?php
    $conn = mysqli_connect('localhost','rupal','1234567890','test');
    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }
?>