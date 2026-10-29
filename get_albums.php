// Fichier: get_albums.php
<?php

require_once "database.php";

$sql = "SELECT * FROM albums";

$request = $pdo->prepare($sql);

$request->execute();

$albums = $request->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");

echo json_encode($albums);

?>
