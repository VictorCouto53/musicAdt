<?php 
    include("includes/includedFiles.php");

    if(isset($_GET['id']))
    	$albumId = $_GET['id'];
    else 
    	header("Location: index.php");
    
    $album = new Album($con, $albumId);
    $artist = $album->getArtist();
    $artistId = $artist->getId();
?>

<div class="entityInfo">

	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></php>
		<p><?php echo $album->getNumberSongs(); ?> songs</p>
	</div>

</div>

<div class="tracklistContainer">
	<ul class="tracklist">
		<?php
		    $songIdArray = $album->getSongs();
    
            $index = 1;
		    forEach($songIdArray as $songId) {
		    	$albumSong = new Song($con, $songId);
		    	$albumArtist = $albumSong->getArtist();
		    	echo "<li class='tracklistRow'>
		    	            <div class='trackCount'>
		    	                <img class='play' src='resources/images/icons/playII.png' onclick='setTrack(\"" . $albumSong->getId() . "\", auxPlaylist, true)'>
		    	                <span class='trackNumber'>$index</span>
		    	            </div>
    
		    	            <div class='trackInfo'>
		    	                 <span class='trackName'>" . $albumSong->getTitle() . "</span>
		    	                 <span class='artistName'>" . $albumArtist->getName() . "</span>
		    	            </div>
    
		    	            <div class='trackOptions'>
		    	                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
		    	                <img class='optionsButton' src='resources/images/icons/dots.png' onclick='showOptionsMenu(this)'>
		    	            </div>
    
		    	            <div class='trackDuration'>
		    	                <span class='duration'>" . $albumSong->getDuration() ."</span>
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
</nav>