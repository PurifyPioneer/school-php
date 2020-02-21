<?php
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

    if (isset($_POST['Delete_Item'])) {

                $pdo = new DBConnector();
                $pdo->connect();
                $pdo->createDatabase();
                $pdo->deleteItem($_POST['id']);
                $pdo->close();
                $newURL = "./index.php";
                header('Location: ' .$newURL);        
        }
?>