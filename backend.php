<?php
    /*
    Backend that will process information send by forms
    and handle user authentication.
    */

    // Process login of user
    if (isset($_POST['login'])) {
        if (!empty($_POST['name']) && !empty($_POST['password'])) {

            $pdo = new DBConnector();
            $pdo->connect();
            $pdo->createDatabase();

            $username_result = $pdo->getUser($_POST['name']);
            $password_result = $pdo->getPassword($_POST['name']);

            if ($_POST['name'] == $username_result && sha1($_POST['password']) == $password_result) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $_POST['name'];
            } else {
                $_SESSION['login_message'] = "Wrong username or password";
            }
        } else {
            $_SESSION['login_message'] = "Username or password cannot be empty";
        }

        $newURL = "./index.php";
        header('Location: ' .$newURL);
    }

    // Process user registration
    if(isset($_POST['register'])) {
        if (!empty($_POST['name']) && !empty($_POST['password'])) {

            $pdo = new DBConnector();
            $pdo->connect();
            $pdo->createDatabase();

            $username = $_POST['name'];
            $password = $_POST['password'];

            $pdo->registerUser($username, $password);
            $_SESSION['login_message'] = "Registered successfully";
        
        }
        $newURL = "./index.php";
        header('Location: ' .$newURL);
    }

    // Process logout
    if (isset($_POST['logout'])) {
        $_SESSION = [];
    }

//-----------------> OLD CODE FROM PREVIOUS TASK <----------------------------

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