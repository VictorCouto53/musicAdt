var userLogged;
var currentPlaylist = [];
var aleatoryPlaylist = [];
var auxPlaylist = [];
var audioElement;
var currentIndex = 0;
var countTime;
var mouseDown = false;
var repeat = false;
var aleatory = false;

$(document).click(function(click) {
	var target = $(click.target);
	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/addSongsPlaylist.php", { playlistId: playlistId, songId: songId}).done(function(error) {
		if(error != "") {
			alert(error);
			return;
		}
		hideOptionsMenu();
		select.val("");
	});
});

function openPage(url){
	if(countTime != null) clearTimeout(countTime);
	if(url.indexOf("?") == -1)
		url = url + "?";

	var encodeUrl = encodeURI(url + "&userLogged=" + userLogged);
	$("#mainContent").load(encodeUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function logOut() {
	$.post("includes/handlers/ajax/logOut.php", function() {
		location.reload();
	});
}

function updateEmail(emailClass) {
	var emailValue = $("." + emailClass).val();

	$.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn})
	.done(function(response) {
		$("." + emailClass).nextAll(".message").text(response);
	});
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword1 = $("." + newPasswordClass1).val();
	var newPassword2 = $("." + newPasswordClass2).val();

	$.post("includes/handlers/ajax/updatePassword.php", 
		{ oldPassword: oldPassword,
			newPassword1: newPassword1,
			newPassword2: newPassword2, 
			username: userLogged})

	.done(function(response) {
		$("." + oldPasswordClass).nextAll(".message").text(response);
	});
}

function createPlaylist() {
	var inputName = prompt("Enter the name of the playlist");
	if(inputName != null) {
		$.post("includes/handlers/ajax/createPlaylist.php", { name: inputName, username: userLogged}).done(function(error) {
			if(error != ""){
				alert(error);
				return;
			}
			openPage("personalMusics.php");
		});
	}
}

function deletePlaylist(playlistId) {
	var inputDelete = confirm("Do you want delete this playlist?");
	if(inputDelete) {
		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId } ).done(function(error) {
			if(error != ""){
				alert(error);
				return;
			}
			openPage("personalMusics.php");
		});
	}
}

function removeSongFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/deleteSongPlaylist.php", { playlistId: playlistId, songId: songId })
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		//do something when ajax returns
		openPage("playlist.php?id=" + playlistId);
	});
}

function showOptionsMenu(button){
	var songId = $(button).prevAll(".songId").val();
	var options = $(".optionsMenu");
	var optionsWidth = options.width();
	options.find(".songId").val(songId);
	var scrollUp = $(window).scrollTop();
	var elementOffset = $(button).offset().top;
	var top = elementOffset - scrollUp;
	var left = $(button).position().left;

	options.css({"top": top + "px", "left": left - optionsWidth + "px", "display": "inline"});
}

function hideOptionsMenu() {
	var options = $(".optionsMenu");
	if(options.css("display") != "none") {
		options.css("display", "none");
	}
}

function timeRepresent(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - (minutes * 60);
	var zero = (seconds < 10) ? "0" : "";
	return minutes + ":" + zero + seconds;
}

function updateTimeBar(audio) {
	$(".progressTime.current").text(timeRepresent(audio.currentTime));
	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeBar(audio){
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(auxPlaylist[0], auxPlaylist, true);
}

function Audio() {
	this.currentPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("canplay", function() {
		var duration = timeRepresent(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateTimeBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeBar(this);
	});

	this.setTrack = function(track) {
		this.currentPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
}