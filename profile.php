<?php  
    include("includes/includedFiles.php");
?>

<div class="entityInfo">
	<div class="centerSection">
		<div class="userInfo">
			<h1><?php echo $userLogged->getFirstAndLastName(); ?></h1>
		</div>
	</div>

	<div class="buttonItems">
		<button class="button" onclick="openPage('updateProfile.php')">User Details</button>
		<button class="button" onclick="logOut()">Log Out</button>
	</div>
</div>