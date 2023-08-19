<?php
    include("../../configure.php");
    
    if(isset($_POST['name']) && isset($_POST['username'])) {
    	$name = $_POST['name'];
    	$username = $_POST['username'];
    	$date = date("Y-m-d");
    	$query = mysqli_query($con, "INSERT INTO playlist VALUES('', '$name', '$username', '$date')");
    }
    else
    	exit();
?>