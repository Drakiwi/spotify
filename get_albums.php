<?php

require_once "database.php";

$sql = "SELECT id, title, artist, cover_path FROM albums ORDER BY title";
$request = $pdo->prepare($sql);
$request->execute();

$albums = $request->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");

echo json_encode($albums);

?>
