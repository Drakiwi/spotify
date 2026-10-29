
<?php

require_once "database.php";

// Récupérer les informations
$title = $_POST["title"];
$albumId = $_POST["album_id"];

// Récupérer les fichiers
$image = $_FILES["cover"];
$audio = $_FILES["audio"];

// Créer les noms des fichiers
$nomImage = uniqid() . "_" . basename($image["name"]);
$nomAudio = uniqid() . "_" . basename($audio["name"]);

// Chemins des fichiers
$coverPath = "asset/covers/" . $nomImage;
$filePath = "asset/musics/" . $nomAudio;

if ($audio["error"] != 0) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur MP3 : " . $audio["error"]
    ]);
    exit;
}

// Enregistrer les fichiers
if (!move_uploaded_file($image["tmp_name"], $coverPath)) {
    echo json_encode([
        "success" => false,
        "message" => "Impossible d'enregistrer l'image"
    ]);
    exit;
}

if (!move_uploaded_file($audio["tmp_name"], $filePath)) {
    echo json_encode([
        "success" => false,
        "message" => "Impossible d'enregistrer le MP3"
    ]);
    exit;
}

// Enregistrer dans MySQL
$sql = "INSERT INTO songs (album_id, title, cover_path, file_path)
        VALUES (:album_id, :title, :cover_path, :file_path)";

$request = $pdo->prepare($sql);

$request->execute([
    "album_id" => $albumId,
    "title" => $title,
    "cover_path" => $coverPath,
    "file_path" => $filePath
]);

echo json_encode([
    "success" => true,
    "message" => "Musique ajoutée !"
]);

?>
