<?php
    include("includes/configure.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");
    
    if(isset($_SESSION['userLogged'])) {
    	$userLogged = new User($con, $_SESSION['userLogged']);
        $username = $userLogged->getUsername();
        echo "<script>userLogged = '$username';</script>";
    }
    else {
    	header("Location: main.php");
    }
?>


<!DOCTYPE html>

<head>
	<title> SpotAdt </title>
    <link rel="stylesheet" type="text/css" href="resources/style-css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script src="resources/js/script.js"></script>
    
</head>

<body>

    <div id="mainContainer">

        <div id="upperContainer">

            <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">
                <div id="mainContent">