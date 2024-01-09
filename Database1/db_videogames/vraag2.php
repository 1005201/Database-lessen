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
        <h4>2. Voor welk platform is het spel 'Donkey Kong Country'?</h4>
            <?php
                try {

                    $gameName = "Donkey Kong Country";

                    $stmt = $conn->prepare("SELECT platform.platform_name
                                                    FROM game
                                                    JOIN game_publisher ON game.id = game_publisher.game_id
                                                    JOIN game_platform ON game_publisher.id = game_platform.game_publisher_id
                                                    JOIN platform ON game_platform.platform_id = platform.id
                                                    WHERE game.game_name = :gameName");

                    $stmt->bindParam(":gameName", $gameName, PDO::PARAM_STR);
                    $stmt->execute();
                    var_dump($stmt);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "Platform: " . $row['platform_name'] . "<br>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>

    </main>
</body>