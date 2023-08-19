<?php 
    include("includes/includedFiles.php");
?>

<div class="playlistContainer">
	<div class="gridViewContainer">
		<h2>Playlists</h2>
		<div class="buttonItems">
			<button class="button color" onclick="createPlaylist()">New Playlist</button>
		</div>

		<?php 
		    $username = $userLogged->getUsername();

            $playlistQuery = mysqli_query($con, "SELECT * FROM playlist WHERE owner='$username'");
    
            if(mysqli_num_rows($playlistQuery) == 0)
	         	echo "<span class='noResults'>You don't have playlist's yet.</span>";
    
            while($row = mysqli_fetch_array($playlistQuery)) {

            	$playlist = new Playlist($con, $row);

                echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() ."\")'>
                            <div class='playlistImage'>
                                <img src='resources/images/icons/colesseum.png'>
                            </div>
                            <div class='gridViewInfo'>"
                                . $playlist->getName() .
                            "</div>                  
                    </div>";
            }
        ?>

	</div>
</div>
