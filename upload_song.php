<?php

require_once "database.php";

header("Content-Type: application/json; charset=utf-8");

// Log de débogage
$logFile = __DIR__ . DIRECTORY_SEPARATOR . "import_debug.log";
function logDebug($message) {
    $logFile = __DIR__ . DIRECTORY_SEPARATOR . "import_debug.log";
    file_put_contents($logFile, date("Y-m-d H:i:s") . " - " . $message . "\n", FILE_APPEND);
}

function repondreErreur($status, $message)
{
    logDebug("ERREUR (HTTP $status): $message");
    http_response_code($status);
    echo json_encode(["error" => $message]);
    exit;
}

logDebug("=== Nouvelle requête reçue ===");
logDebug("Méthode: " . $_SERVER["REQUEST_METHOD"]);
logDebug("FILES: " . print_r($_FILES, true));
logDebug("POST: " . print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    repondreErreur(405, "Méthode non autorisée.");
}

function tailleEnOctets($valeur)
{
    $valeur = trim($valeur);
    $unite = strtolower(substr($valeur, -1));
    $nombre = (int) $valeur;

    switch ($unite) {
        case "g":
            $nombre *= 1024;
        case "m":
            $nombre *= 1024;
        case "k":
            $nombre *= 1024;
    }

    return $nombre;
}

$tailleMaxPost = tailleEnOctets(ini_get("post_max_size"));
$tailleRequete = (int) ($_SERVER["CONTENT_LENGTH"] ?? 0);
if ($tailleMaxPost > 0 && $tailleRequete > $tailleMaxPost) {
    repondreErreur(
        413,
        "Les fichiers dépassent la limite WAMP post_max_size (" . ini_get("post_max_size") . "). Augmente cette valeur dans le php.ini utilisé par Apache, puis redémarre WAMP."
    );
}

$title = trim($_POST["title"] ?? "");
$artist = trim($_POST["artist"] ?? "");
$albumId = trim($_POST["album_id"] ?? "");

if (
    $title === ""
    || $artist === ""
    || $albumId === ""
    || mb_strlen($title, "UTF-8") > 255
    || mb_strlen($artist, "UTF-8") > 255
) {
    repondreErreur(400, "Le titre, l'artiste et l'album sont obligatoires.");
}

// Vérifier que l'album existe
$checkAlbum = $pdo->prepare("SELECT id FROM albums WHERE id = :id");
$checkAlbum->execute(["id" => $albumId]);
if ($checkAlbum->fetch() === false) {
    repondreErreur(400, "L'album sélectionné n'existe pas.");
}

foreach (["cover", "audio"] as $field) {
    if (!isset($_FILES[$field])) {
        repondreErreur(400, "La pochette et le fichier MP3 sont obligatoires et doivent être correctement envoyés.");
    }

    if ($_FILES[$field]["error"] !== UPLOAD_ERR_OK) {
        $erreurUpload = $_FILES[$field]["error"];
        if ($erreurUpload === UPLOAD_ERR_INI_SIZE) {
            repondreErreur(
                413,
                "Le fichier « " . ($field === "audio" ? "MP3" : "pochette") . " » dépasse la limite WAMP upload_max_filesize (" . ini_get("upload_max_filesize") . "). Augmente cette valeur dans le php.ini utilisé par Apache, puis redémarre WAMP."
            );
        }

        if ($erreurUpload === UPLOAD_ERR_PARTIAL) {
            repondreErreur(400, "L’envoi du fichier a été interrompu. Réessaie.");
        }

        repondreErreur(400, "Impossible de recevoir le fichier « " . ($field === "audio" ? "MP3" : "pochette") . " » (erreur d’upload " . $erreurUpload . ").");
    }

    if (!is_uploaded_file($_FILES[$field]["tmp_name"])) {
        repondreErreur(400, "Fichier envoyé invalide.");
    }
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

$audioMime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES["audio"]["tmp_name"]);
$audioExtension = strtolower(pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION));
if ($audioExtension !== "mp3" || !in_array($audioMime, ["audio/mpeg", "audio/mp3", "audio/x-mpeg"], true)) {
    repondreErreur(400, "Le fichier audio doit être un MP3 valide.");
}

$coverDirectory = __DIR__ . DIRECTORY_SEPARATOR . "asset" . DIRECTORY_SEPARATOR . "covers";
$audioDirectory = __DIR__ . DIRECTORY_SEPARATOR . "asset" . DIRECTORY_SEPARATOR . "musiques";

foreach ([$coverDirectory, $audioDirectory] as $directory) {
    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        repondreErreur(500, "Impossible de préparer le stockage des fichiers.");
    }
}

$fileId = bin2hex(random_bytes(16));
$coverName = $fileId . "." . $coverExtensions[$coverMime];
$audioName = $fileId . ".mp3";
$coverPath = $coverDirectory . DIRECTORY_SEPARATOR . $coverName;
$audioPath = $audioDirectory . DIRECTORY_SEPARATOR . $audioName;
$coverRelativePath = "asset/covers/" . $coverName;
$audioRelativePath = "asset/musiques/" . $audioName;

if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
    repondreErreur(500, "Impossible d’enregistrer la pochette.");
}

if (!move_uploaded_file($_FILES["audio"]["tmp_name"], $audioPath)) {
    unlink($coverPath);
    repondreErreur(500, "Impossible d’enregistrer le fichier MP3.");
}

try {
    $pdo->beginTransaction();

    $songRequest = $pdo->prepare(
        "INSERT INTO songs (album_id, title, file_path) VALUES (:album_id, :title, :file_path)"
    );
    $songRequest->execute([
        "album_id" => $albumId,
        "title" => $title,
        "file_path" => $audioRelativePath
    ]);

    $pdo->commit();
    echo json_encode(["message" => "La musique a été importée avec succès."]);
} catch (Throwable $error) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    unlink($coverPath);
    unlink($audioPath);
    error_log("Échec de l'import d'une musique : " . $error->getMessage());
    repondreErreur(500, "Impossible d'enregistrer la musique dans la base de données.");
}
