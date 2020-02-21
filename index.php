<?php
        require_once('db_connector.php');
        require_once('backend.php');
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
    
    </div>
    
    <div class='row'>
        <div class='column'>
            <div class='columnborder'>
            <form class=add_item action="./index.php">
                   <input type="text" name="name">
                  <input type="submit" value="Submit">
          </form>
</div>
         </div>

        <div class='column'>
        <div class='columnborder'>
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
                        <form action='./index.php' method='post'>
                            <input type='submit' class='button' name='Delete Item' value='delete'/>
                            <input type='hidden' name='id' value='$id'/>
                        </form>
                    </div>";
            }
        ?>
        </div>
        </div>
    </div>

    </body>
    </html>