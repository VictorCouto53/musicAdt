<?php
    include("includes/includedFiles.php");

    if(isset($_GET['id']))
    	$artistId = $_GET['id'];
    else
    	header("Location: index.php");
    
    $artist = new Artist($con, $artistId);
?>

<div class="entityInfo borderBottom">
	<div class="centerSetion">
		<div class="artistInfo">
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>
			<div class="headerButtons">
				<button class="button color" onclick="playFirstSong()">Play</button>
			</div>
		</div>	
	</div>
</div>

<div class="tracklistContainer borderBottom">
	<h2>Songs</h2>
	<ul class="tracklist">
		<?php
		    $songIdArray = $artist->getSongs();
    
            $index = 1;
		    forEach($songIdArray as $songId){
		    	if($index > 6)
		    		break;
    
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

<div class="gridViewContainer">
	<h2>Albums</h2>
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

        while($row = mysqli_fetch_array($albumQuery)) {

            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath']. "'>

                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                    </span>
                </div>";
        }
    ?>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con, $userLogged->getUsername()); ?>
</nav>