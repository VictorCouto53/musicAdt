<?php
    include("includes/configure.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");


    function getInput($var) {
        if(isset($_POST[$var]))
            echo $_POST[$var];    
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title> MusicAdt - Music Free </title>
    <link rel="stylesheet" type="text/css" href="resources/style-css/registerInterface.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="resources/js/register.js"></script>
</head>

<body>

    <?php 

        if(isset($_POST['registerButton'])) {
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").hide();
                        $("#registerForm").show();
                    });
                </script>';
        }
        else {
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").show();
                        $("#registerForm").hide();
                    });
                </script>';
        }        
    ?>



    <div id="background">

        <div id="loginContainer">

            <div id="inputContainer">

                <form id="loginForm" action="main.php" method="POST">
                    <h2>Sign In your Account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginRecused); ?>
                    	<label for="loginUsername">Username</label>
                    	<input id="loginUsername" name ="loginUsername" type="text" placeholder="Username" required>
                    </p>
                    <p>
                    	<label for="loginPassword">Password</label>
                    	<input id="loginPassword" name ="loginPassword" type="password" placeholder="Password" required>
                    </p>
                    <button type="submit" name="loginButton">Log In</button>

                    <div class="hasAccount">
                        <span id="hideLogin"> Don't have an account? Sign Up here.</span>
                    </div>
                </form>
        
                <form id="registerForm" action="main.php" method="POST">
                    <h2>Create your Account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameRange); ?>
                        <?php echo $account->getError(Constants::$idExistet); ?>
                    	<label for="idUsername">Username</label>
                    	<input id="idUsername" name ="idUsername" type="text" placeholder="Username" value ="<?php getInput('idUsername') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$firstNameRange); ?>
                    	<label for="firstName">First Name</label>
                    	<input id="firstName" name ="firstName" type="text" placeholder="First name" value ="<?php getInput('firstName') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$lastNameRange); ?>
                    	<label for="lastName">Last Name</label>
                    	<input id="lastName" name ="lastName" type="text" placeholder="Last name" value ="<?php getInput('lastName') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailExistet); ?>
                    	<label for="email">Email</label>
                    	<input id="email" name ="email" type="email" placeholder="Your email" value ="<?php getInput('email') ?>" required>
                    </p>
                    <p>
                    	<label for="validEmail">Confirm Email</label>
                    	<input id="validEmail" name ="validEmail" type="email" placeholder="Confirm email" value ="<?php getInput('validEmail') ?>" required>
                    </p>
                    <p>
                    	<label for="password">Password</label>
                    	<input id="password" name ="password" type="password" placeholder="Password" value ="<?php getInput('password') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$passwordsNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
                        <?php echo $account->getError(Constants::$passwordsNotRange); ?>
                    	<label for="validPassword">Confirm Password</label>
                    	<input id="validPassword" name ="validPassword" type="password" placeholder="Confirm password" value ="<?php getInput('validPassword') ?>" required>
                    </p>
        
                    <button type="submit" name="registerButton">Sign Up</button>
                    <div class="hasAccount">
                        <span id="hideRegister"> Have an account? Log In here.</span>
                    </div>
                </form>    
            </div>

            <div id="loginText">
                <h1>Discover new musics</h1>
                <h2>Listen songs for free</h2>
                <ul>
                    <li>Discover new musics</li>
                    <li>Follow your favorites artits</li>
                    <li>Create your own playlists</li>
                </ul>
            </div>
        </div>
    </div>    
</body>
</html>