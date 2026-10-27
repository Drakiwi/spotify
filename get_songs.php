<?php

require_once "database.php";

$sql = "SELECT songs.*, albums.artist, albums.cover_path
        FROM songs
        JOIN albums ON songs.album_id = albums.id";

$request = $pdo->prepare($sql);

$request->execute();

$songs = $request->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");

echo json_encode($songs);

?>