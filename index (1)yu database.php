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
//opdracht 1
$get_data = "SELECT genre.genre_name, count(game.id) AS game_count FROM genre
             LEFT JOIN game ON genre.id = game.genre_id
             GROUP BY genre.genre_name";
$query = $conn->query($get_data);
$prepare = $query->fetchAll(PDO::FETCH_ASSOC);


foreach ($prepare as $genre) {
    echo $genre["genre_name"] . ": " . $genre["game_count"] . " games";
    echo "<br>";
}
echo "<br>";
//opdracht 2
if (isset($_POST['search_game'])) {
    $sql = $conn->prepare("SELECT game.game_name, platform.platform_name
                                    FROM game
                                    JOIN game_publisher ON game.id = game_publisher.game_id
                                    JOIN game_platform ON game_publisher.id = game_platform.game_publisher_id
                                    JOIN platform ON game_platform.platform_id = platform.id
                                    WHERE game.game_name = :search_term");
    $sql->bindParam(":search_term", $_POST['search_term']);
    $sql->execute();

    $result = $sql->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "Game found: " . $result['game_name'];
        echo "<br>";
        echo "Platform: " . $result['platform_name'];
    } else {
        echo "Game not found.";
    }

}
echo "<br>";
//opdracht 3
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
echo "<br>";
//opdracht 4
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
<!--opdracht 2-->
<form method="POST">
    <input type="text" name="search_term" placeholder="Enter game name">
    <input type="submit" name="search_game" value="Search">
</form>
<!--opdracht 3-->
<form method="POST">
    <input type="text" name="search_maker" placeholder="Enter game creator name">
    <input type="submit" name="search_creator" value="Search">
</form>



