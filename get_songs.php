
<?php

require_once "database.php";

header("Content-Type: application/json");


$sql = "SELECT songs.*, albums.artist
        FROM songs
        JOIN albums ON songs.album_id = albums.id";

// Vérifier sélection album
if (isset($_GET["album_id"])) {

    $sql = $sql . " WHERE songs.album_id = :album_id";

    $request = $pdo->prepare($sql);

    $request->execute([
        "album_id" => $_GET["album_id"]
    ]);

} else {

    $request = $pdo->prepare($sql);

    $request->execute();

}


$songs = $request->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($songs);

?>
