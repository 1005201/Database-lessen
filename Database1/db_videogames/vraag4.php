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
        <h4>4. Toon een lijst van regio's met de hoeveelheid spellen per regio.</h4>
        <?php
            $sql = $conn->prepare("SELECT region.region_name AS region_id, COALESCE(SUM(region_sales.num_sales), 0) AS total_sales
            FROM region
            LEFT JOIN region_sales ON region.id = region_sales.region_id
            GROUP BY region.id");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
            echo "<br>";
            foreach ($result as $row) {
            echo "Region Name: " . $row['region_id'] . "<br>";
            echo "Total Sales: " . $row['total_sales'] . "<br>";
            }
            } else {
            echo "No results found.";
            }

        ?>
    </main>
</body>