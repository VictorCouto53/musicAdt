<?php

    if(isset($_POST['loginButton'])) {
        $idUsername = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        $result = $account->login($idUsername, $password);

        if($result == true) {
          $_SESSION['userLogged'] = $idUsername;
          header("Location: index.php");
        }
    }

?>