<?php
    
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    	include("includes/configure.php");
        include("includes/classes/User.php");
        include("includes/classes/Artist.php");
        include("includes/classes/Album.php");
        include("includes/classes/Song.php");
        include("includes/classes/Playlist.php");  

        if(isset($_GET['userLogged'])) {
            $userLogged = new User($con, $_GET['userLogged']);
        }  
    }
    else {
    	include("includes/header.php");
    	include("includes/footer.php");
    	$url = $_SERVER['REQUEST_URI'];
    	echo "<script>openPage('$url')</script>";
    	exit();
    }

?>