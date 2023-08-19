<?php 
    include("includes/includedFiles.php");

    if(isset($_GET['id']))
    	$playlistId = $_GET['id'];
    else
    	header("Location: index.php");    
    
    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getOwner());
    
?>

<div class="entityInfo">

	<div class="leftSection">
		<div class="playlistImage">
			<img src="resources/images/icons/colesseum.png">
		</div>
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberSongs(); ?> songs</p>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')"> Delete Playlist</button>
	</div>

</div>

<div class="tracklistContainer">
	<ul class="tracklist">
		<?php
		    $songIdArray = $playlist->getSongs();
    
            $index = 1;
		    forEach($songIdArray as $songId){
		    	$playlistSong = new Song($con, $songId);
		    	$songArtist = $playlistSong->getArtist();
		    	
		    	echo "<li class='tracklistRow'>
		    	            <div class='trackCount'>
		    	                <img class='play' src='resources/images/icons/playII.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", auxPlaylist, true)'>
		    	                <span class='trackNumber'>$index</span>
		    	            </div>
    
		    	            <div class='trackInfo'>
		    	                 <span class='trackName'>" . $playlistSong->getTitle() . "</span>
		    	                 <span class='artistName'>" . $songArtist->getName() . "</span>
		    	            </div>
    
		    	            <div class='trackOptions'>
		    	                <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
		    	                <img class='optionsButton' src='resources/images/icons/dots.png' onclick='showOptionsMenu(this)'>
		    	            </div>
    
		    	            <div class='trackDuration'>
		    	                <span class='duration'>" . $playlistSong->getDuration() ."</span>
		    	            </div>
		    	      </li>";
		    	$index += 1;
		    }
		?>

		<script>
			var auxSongsId = '<?php echo json_encode($songIdArray); ?>';
			auxPlaylist = JSON.parse(auxSongsId);
		</script>

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con, $userLogged->getUsername()); ?>
	<div class="item" onclick="removeSongFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
</nav>
