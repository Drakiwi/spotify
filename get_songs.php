
<?php

require_once "database.php";

header("Content-Type: application/json");

// Récupérer les musiques avec leur artiste
$sql = "SELECT songs.*, albums.artist
        FROM songs
        JOIN albums ON songs.album_id = albums.id";

// Vérifier si on a sélectionné un album
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

// Récupérer les résultats
$songs = $request->fetchAll(PDO::FETCH_ASSOC);

// Envoyer les musiques en JSON
echo json_encode($songs);

?>
