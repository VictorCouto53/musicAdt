<?php
    class Account {
    	private $con;
    	private $errorArray;

    	public function __construct($con) {
    		$this->con = $con;
    		$this->errorArray = array();
    	}

    	public function login($id, $pw) {
    		$pw = md5($pw);

    		$sqlQuery = mysqli_query($this->con, "SELECT * FROM users WHERE username='$id' AND password='$pw'");
    		if(mysqli_num_rows($sqlQuery) == 1) {
    			return true;
    		}
    		else {
    			array_push($this->errorArray, Constants::$loginRecused);
    			return false;
    		}
    	}

    	public function register($id, $fn, $ln, $em, $emII, $pw, $pwII) {
    		$this->validateUsername($id);
	        $this->validateFirstName($fn);
	        $this->validateLastName($ln);
	        $this->validateEmail($em, $emII);
	        $this->validatePassword($pw, $pwII);  

	        if(empty($this->errorArray) == true) {
	        	return $this->insertUserDataBase($id, $fn, $ln, $em, $pw);
	        }
	        else {
	        	return false;
	        }
    	}

    	public function getError($error) {
    		if(!in_array($error, $this->errorArray)) {
    			$error = "";
    		}
    		return "<span class='errorMessage'>$error</span>";
    	}

        private function insertUserDataBase($id, $fn, $ln, $em, $pw) {
        	$encryptPassword = md5($pw);
        	$profilePic = "resources/images/profilePics/test.jpg";
        	$date = date("Y-m-d");

        	$result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$id', '$fn', '$ln', '$em', '$encryptPassword', '$date', '$profilePic')");
        	return $result;
        }




        private function validateUsername($username) {
        	if(strlen($username) > 20 || strlen($username) < 5) {
        		array_push($this->errorArray, Constants::$usernameRange);
        		return;
        	}

        	$idUserVerification = mysqli_query($this->con, "SELECT username FROM users where username='$username'");
        	if(mysqli_num_rows($idUserVerification) != 0) { 
        		array_push($this->errorArray, Constants::$idExistet);
        		return;
        	}
        }
    
        private function validateFirstName($firstName) {  
            if(strlen($firstName) > 20 || strlen($firstName) < 2) {
        		array_push($this->errorArray, Constants::$firstNameRange);
        		return;
        	}  	
        }
        
        private function validateLastName($lastName) {
        	if(strlen($lastName) > 20 || strlen($lastName) < 2) {
        		array_push($this->errorArray, Constants::$lastNameRange);
        		return;
        	}
        	
        }
        
        private function validateEmail($email, $emailII) {
        	if($email != $emailII) {
        		array_push($this->errorArray, Constants::$emailNotMatch);
        		return;
        	}

        	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        		array_push($this->errorArray, Constants::$emailInvalid);
        		return;
        	}

        	$emailVerification = mysqli_query($this->con, "SELECT email FROM users where email='$email'");
        	if(mysqli_num_rows($emailVerification) != 0) { 
        		array_push($this->errorArray, Constants::$emailExistet);
        		return;
        	}
        }
        
        private function validatePassword($password, $passwordII) {
        	if($password != $passwordII) {
        		array_push($this->errorArray, Constants::$passwordsNotMatch);
        		return;
        	}

        	if(preg_match('/[^A-Za-z-0-9]/', $password)) {
        		array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
        	}

        	if(strlen($password) > 20 || strlen($password) < 5) {
        		array_push($this->errorArray, Constants::$passwordsNotRange);
        		return;
        	}
        }  
    }  
?>