<?php
    include("includes/includedFiles.php");

    if(isset($_GET['term']))
    	$term = urldecode($_GET['term']);    
    else
    	$term = "";
?>

<div class="searchContainer">
	<h4>Search for an artist, song or album</h4>
	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Search for what do you want to listen" onfocus="var val=this.value; this.value=''; this.value= val;">
</div>

<script>
	$(".searchInput").focus();
	$(function() {
		$(".searchInput").keyup(function() {
			clearTimeout(countTime);
			countTime = setTimeout(function() {
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
			}, 2000);
		});
		$(".searchInput").focus();
	});

</script>

<?php
    if($term == "")
    	exit();
    ?>

<div class="tracklistContainer borderBottom">
	<h2>Songs</h2>
	<ul class="tracklist">
		<?php
		    $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
		    if(mysqli_num_rows($songsQuery) == 0)
		    	echo "<span class='noResults'>No songs found " . $term . "</span>";
    
		    $songIdArray = array();
            $index = 1;
		    while($row = mysqli_fetch_array($songsQuery)) {
		    	if($index > 12)
		    		break;
		    	array_push($songIdArray, $row['id']);
    
		    	$albumSong = new Song($con, $row['id']);
		    	$albumArtist = $albumSong->getArtist();
		    	echo "<li class='tracklistRow'>
		    	            <div class='trackCount'>
		    	                <img class='play' src='resources/images/icons/play-circled-black.png' onclick='setTrack(\"" . $albumSong->getId() . "\", auxPlaylist, true)'>
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

<div class="artistContainer borderBottom">
	<h2>Artists</h2>
	<?php 
	    $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
	    if(mysqli_num_rows($artistsQuery) == 0)
	     	echo "<span class='noResults'>No artists found: " . $term . "</span>";

	    while($row = mysqli_fetch_array($artistsQuery)) {
	    	$artistFound = new Artist($con, $row['id']);

	     	echo "<div class='searchResultRow'>
	     	            <div class='artistName'>
	     	                <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() ."\")'>
	     	                "
	     	                . $artistFound->getName() .
	     	                "
	     	               </span>
	     	            </div>
	     	      </div>";

	    }
	?>
</div>

<div class="gridViewContainer">
	<h2>Albums</h2>
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($albumQuery) == 0)
	     	echo "<span class='noResults'>No albums found: " . $term . "</span>";

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

