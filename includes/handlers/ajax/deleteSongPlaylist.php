<?php
    include("../../configure.php");
    
    if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    	$playlistId = $_POST['playlistId'];
    	$songId = $_POST['songId'];
    	$query = mysqli_query($con, "DELETE FROM SongsPlaylist WHERE playlistId='$playlistId' AND songId='$songId'");
    }
    else
    	echo "PlaylistId or songId was not passed into removeFromPlaylist.php";
    

?>    