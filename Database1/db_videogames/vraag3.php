<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "video_games";

try {
    $conn = new PDO("mysql:host=$servername;dbname=video_games", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylen.css">
</head>
<body>
    <header>
        <nav>
            <div class="image1">
                <a href="index.html"><img src="Fate-of-Game-Preservation-Games-GettyImages-1170073827.webp" style="height: 100px;"></a>
                <h1 style="padding: 0 600px">Beheer</h1>
            </div>
        </nav>
    </header>
    <main>

            <h4>3. Welke spellen heeft de uitgever 'Zoo Games' uitgebracht?</h4>

            <?php
            if (isset($_POST["search_creator"])) {
                try {
                    $sql = $conn->prepare("SELECT publisher.publisher_name, game.game_name
                                FROM publisher
                                JOIN game_publisher ON game_publisher.publisher_id = publisher.id
                                JOIN game ON game.id = game_publisher.game_id
                                WHERE publisher.publisher_name = :search_maker");
                    $sql->bindParam(":search_maker", $_POST['search_maker']);
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($result)) {
                        echo "Creator found: " . $result[0]['publisher_name'];
                        echo "<br>Games by this creator:<br>";
                        foreach ($result as $row) {
                            echo $row['game_name'] . "<br>";
                        }
                    } else {
                        echo "Creator not found.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>
        <form method="POST">
            <input type="text" name="search_maker" placeholder="Enter game creator name">
            <input type="submit" name="search_creator" value="Search">
        </form>
    </main>
</body>