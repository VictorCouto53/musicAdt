<?php

    $songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
    var newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
    });

    $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown == true){
            timeOffSet(e, this);
        }
    });

    $(".playbackBar .progressBar").mouseup(function(e) {
        timeOffSet(e, this);
    });

    $(".volumeBar .progressBar").mousedown(function() {
        mouseDown = true;
    });

    $(".volumeBar .progressBar").mousemove(function(e) {
        if(mouseDown == true){
            var percento = e.offsetX / $(this).width();
            if(percento >= 0 && percento <= 1){
                audioElement.audio.volume = percento;
            }
        }
    });

    $(".volumeBar .progressBar").mouseup(function(e) {
        var percento = e.offsetX / $(this).width();
        if(percento >= 0 && percento <= 1){
                audioElement.audio.volume = percento;
        }
    });

    $(document).mouseup(function() {
        mouseDown = false;
    });

});

function timeOffSet(mouse, progressBar){
    var percento = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percento / 100);
    audioElement.setTime(seconds);
}

function previousSong() {
    if(audioElement.audio.currentTime >= 3 || currentIndex == 0)
        audioElement.setTime(0);
    else {
        currentIndex -= 1;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
}

function nextSong() {
    if(repeat == true) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if(currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0;
    }
    else {
        currentIndex++;
    }
    var trackNext = aleatory ? aleatoryPlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackNext, currentPlaylist, true);
}

function setRepeat() {
    repeat = !repeat;
    var imgName = repeat ? "repeat-one.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "resources/images/icons/" + imgName);
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imgName = audioElement.audio.muted ? "mute.png" : "audio.png";
    $(".controlButton.volume img").attr("src", "resources/images/icons/" + imgName);
}

function setAleatory() {
    aleatory = !aleatory;
    var imgName = aleatory ? "aleatory-on.png" : "aleatory.png";
    $(".controlButton.aleatory img").attr("src", "resources/images/icons/" + imgName);

    if(aleatory == true){
        aleatoryArray(aleatoryPlaylist);
        currentIndex = aleatoryPlaylist.indexOf(audioElement.currentPlaying.id);
    }
    else{
        currentIndex = currentPlaylist.indexOf(audioElement.currentPlaying.id);
    }
}

function aleatoryArray(playlist){
    var t,e,s;
    for (s = playlist.length; s; s--){
        t = Math.floor(Math.random() * s);
        e = playlist[s - 1];
        playlist[s - 1] = playlist[t];
        playlist[t] = e;
    }
}


function setTrack(trackId, newPlaylist, play) {

    if(newPlaylist != currentPlaylist){
        currentPlaylist = newPlaylist;
        aleatoryPlaylist = currentPlaylist.slice();
        aleatoryArray(aleatoryPlaylist);
    }

    if(aleatory == true){
        currentIndex = aleatoryPlaylist.indexOf(trackId);
    }
    else {
        currentIndex = currentPlaylist.indexOf(trackId);
    }
    pauseSong();

    $.post("includes/handlers/ajax/jsonGetSong.php", { songId: trackId }, function(data) {

        var track = JSON.parse(data);
        $(".trackName span").text(track.title);

        $.post("includes/handlers/ajax/jsonGetArtist.php", { artistId: track.artist }, function(data) {
            var artist = JSON.parse(data);
            $(".trackInfo .artistName span").text(artist.name);
            $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
        });

        $.post("includes/handlers/ajax/jsonGetAlbum.php", { albumId: track.album }, function(data) {
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artworkPath);
            $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
        });

        audioElement.setTrack(track);
        if(play == true) {
            playSong();
        }  
    });

}

function playSong() {

    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updateStateSong.php", { songId: audioElement.currentPlaying.id });
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong() {
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

</script>



<div id="nowPlayingBarContainer">

    <div id="nowPlayingBar">
    
        <div id="nowPlayingLeft">
    
            <div class="content">
    
                <span class="albumLink">
                    <img role="link" tabindex="0" src="" class="albumArtwork">
                </span>
    
                <div class="trackInfo">
                            
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>
    
                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>
                </div>
    
            </div>
    
        </div>
    
        <div id="nowPlayingCenter">
    
            <div class="content playerControls">
    
                <div class="buttons">
    
                    <button class="controlButton aleatory" title="Aleatory button" onclick="setAleatory()">
                        <img src="resources/images/icons/aleatory.png" alt="aleatory">
                     </button>
                    <button class="controlButton arrow left" title="Arrow left button" onclick="previousSong()">
                           <img src="resources/images/icons/previous.png" alt="arleft">
                    </button>
    
                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="resources/images/icons/play.png" alt="play">
                    </button>
    
                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                        <img src="resources/images/icons/pause.png" alt="pause">
                    </button>
    
                    <button class="controlButton arrow rigth" title="Arrow right button" onclick="nextSong()">
                         <img src="resources/images/icons/next.png" alt="arrgith">
                     </button>
    
                     <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
                         <img src="resources/images/icons/repeat.png" alt="repeat">
                      </button>
    
                </div>
    
                <div class="playbackBar">
    
                    <span class="progressTime current">0.00</span>
    
                    <div class="progressBar">
                                
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
    
                    <span class="progressTime remaining">0.00</span>
    
                </div>
    
            </div>
    
        </div>
    
        <div id="nowPlayingRight">
    
            <div class="volumeBar">
    
                 <button class="controlButton volume" title="Volume button" onclick="setMute()">
                    <img src="resources/images/icons/audio.png" alt="Volume">
                </button>
    
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
    
            </div>
    
        </div>
    
    </div>
</div>

