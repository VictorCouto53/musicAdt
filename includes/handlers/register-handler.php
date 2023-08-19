<?php

    function formalizeUsername($input){
    	$input = strip_tags($input);
    	$input = str_replace(" ", "", $input);
    	return $input;
    }
    
    function formalizePassword($input){
    	$input = strip_tags($input);
    	return $input;
    }
    
    function formalizeString($input){
    	$input = strip_tags($input);
    	$input = str_replace(" ", "", $input);
    	$input = ucfirst(strtolower($input));
    	return $input;
    }
    
    if(isset($_POST['registerButton'])) {
    	$idUsername = formalizeUsername($_POST['idUsername']);
    	$firstName = formalizeString($_POST['firstName']);
    	$lastName = formalizeString($_POST['lastName']);
    	$email = formalizeString($_POST['email']);
    	$validEmail = formalizeString($_POST['validEmail']);
    	$password = formalizePassword($_POST['password']);
    	$validPassword = formalizePassword($_POST['validPassword']);
    
    	$permitted = $account->register($idUsername, $firstName, $lastName, $email , $validEmail , $password , $validPassword);
    
    	if ($permitted == true) {
    		$_SESSION['userLogged'] = $idUsername;
    		header("Location: index.php");
    	}
    }
?>
