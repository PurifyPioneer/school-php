<?php
    if (isset($_POST['login'])) {
        if (isset($_POST['name'], $_POST['password'])) {

            $pdo = new DBConnector();
            $pdo->connect();
            $pdo->createDatabase();

            $username_result = $pdo->getUser($_POST['name']);
            $password_result = $pdo->getPassword($_POST['name']);

            error_log( print_r( $username_result, true ) );
            error_log( print_r( $password_result, true ) );

            if ($_POST['name'] == $username_result && $_POST['password'] == $password_result) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $_POST['name'];
            } else {
                $_SESSION['login_message'] = "Wrong username or password";
            }
        }
        $newURL = "./index.php";
        header('Location: ' .$newURL);
    }

    if (isset($_POST['logout'])) {
        $_SESSION = [];
    }


    if (isset($_GET['name'])) {
        $pdo = new DBConnector();
        $pdo->connect();
        $pdo->createDatabase();
        $pdo->insertItem($_GET['name']);
        $pdo->close();
        $newURL = "./index.php";
        header('Location: ' .$newURL);
    }

    //print array test
    //echo '<pre>'; print_r($_POST); echo '</pre>';

    if (isset($_POST['delete'])) {

                $pdo = new DBConnector();
                $pdo->connect();
                $pdo->createDatabase();
                $pdo->deleteItem($_POST['id']);
                $pdo->close();
                $newURL = "./index.php";
                header('Location: ' .$newURL);        
    }

?>