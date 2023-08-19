<?php
    include("../../configure.php");

    if(isset($_POST['playlistId'])) {
    	$playlistId = $_POST['playlistId'];
    	$playlistQuery = mysqli_query($con, "DELETE FROM playlist WHERE id='$playlistId'");
    	$songQuery = mysqli_query($con, "DELETE FROM SongsPlaylist WHERE playlistId='$playlistId'");
    }
    else
    	echo "Playlist delete failed";

?>