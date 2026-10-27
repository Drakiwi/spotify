<?php

require_once "database.php";

header("Content-Type: application/json; charset=utf-8");

function repondreErreur($status, $message)
{
    http_response_code($status);
    echo json_encode(["error" => $message]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    repondreErreur(405, "Méthode non autorisée.");
}

$title = trim($_POST["title"] ?? "");
$artist = trim($_POST["artist"] ?? "");

if ($title === "" || $artist === "" || mb_strlen($title, "UTF-8") > 255 || mb_strlen($artist, "UTF-8") > 255) {
    repondreErreur(400, "Le titre et l'artiste sont obligatoires.");
}

if (!isset($_FILES["cover"]) || $_FILES["cover"]["error"] !== UPLOAD_ERR_OK) {
    repondreErreur(400, "La pochette est obligatoire.");
}

$coverInfo = getimagesize($_FILES["cover"]["tmp_name"]);
$coverMime = $coverInfo["mime"] ?? "";
$coverExtensions = [
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/webp" => "webp"
];

if ($coverInfo === false || !isset($coverExtensions[$coverMime])) {
    repondreErreur(400, "La pochette doit être une image JPEG, PNG ou WebP valide.");
}

$coverDirectory = __DIR__ . DIRECTORY_SEPARATOR . "asset" . DIRECTORY_SEPARATOR . "covers";

if (!is_dir($coverDirectory) && !mkdir($coverDirectory, 0755, true) && !is_dir($coverDirectory)) {
    repondreErreur(500, "Impossible de préparer le stockage des fichiers.");
}

$fileId = bin2hex(random_bytes(16));
$coverName = $fileId . "." . $coverExtensions[$coverMime];
$coverPath = $coverDirectory . DIRECTORY_SEPARATOR . $coverName;
$coverRelativePath = "asset/covers/" . $coverName;

if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
    repondreErreur(500, "Impossible d'enregistrer la pochette.");
}

try {
    $request = $pdo->prepare(
        "INSERT INTO albums (title, artist, cover_path) VALUES (:title, :artist, :cover_path)"
    );
    $request->execute([
        "title" => $title,
        "artist" => $artist,
        "cover_path" => $coverRelativePath
    ]);

    echo json_encode(["message" => "L'album a été créé avec succès.", "id" => $pdo->lastInsertId()]);
} catch (Throwable $error) {
    unlink($coverPath);
    error_log("Échec de la création d'un album : " . $error->getMessage());
    repondreErreur(500, "Impossible d'enregistrer l'album dans la base de données.");
}
