<?php
    include "connection.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE from `home` where id=$id";
        $conn->query($sql);
    }
    header('location:/tms/home.php');
    exit;
?>