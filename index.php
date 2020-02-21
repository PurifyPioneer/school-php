<?php
        require_once('DBConnector.php');

        if (isset($_GET['name'])) {
            $pdo = new DBConnector();
            $pdo->connect();
            $pdo->createDatabase();
            $pdo->insertItem($_GET['name']);
            $pdo->close();
            $newURL = "./index.php";
            header('Location: ' .$newURL);
        }

        // does not get called?
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'delete':
                    $pdo = new DBConnector();
                    $pdo->connect();
                    $pdo->createDatabase();
                    $pdo->deleteItem($_POST['id']);
                    $pdo->close();
                    echo $_POST['id'];
                    $newURL = "./index.php";
                    //header('Location: ' .$newURL);
                    break;
        
                }
            }
?>

<!DOCTYPE html>
<html>
<head>
    <title>ITF-18a</title>
    <link rel="stylesheet" type="text/css" href="./static/style.css">
</head>
<body>
<div>

    <nav>
        <label>Websphop</label> <br>
        <button>Main</button>
        <button>Shop</button>
    </nav>

    <form class=add_item action="./index.php">
            <input type="text" name="name">
            <input type="submit" value="Submit">
        </form>
    </div>

    <?php
        $pdo = new DBConnector();
        $pdo->connect();
        $items = $pdo->getItems();
        echo "<label>Items:</label>";
        $items = array_reverse($items);
        foreach ($items as $item) {
            generateItem($item['id'], $item['name']);
            echo "<br>";
        }
        $pdo->close();

        function generateItem($id, $name) {
            echo "<div class='item'>
                    <label>ID: </label> $id <label>Name: $name </label>
                    <form action='./index.php' method='POST'>
                        <input type='submit' class='button' name='Delete Item' value='delete'/>
                        <input type='hidden' name='id' value='$id'/>
                    </form>
                </div>";
        }
    ?>

    </body>
    </html>