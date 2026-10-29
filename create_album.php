// Fichier: create_album.php

<?php

require_once "database.php";

header("Content-Type: application/json; charset=utf-8");


// Vérifier que le formulaire utilise POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "success" => false,
        "message" => "Requête incorrecte"
    ]);

    exit;
}


// Récupérer le titre et l'artiste
$title = trim($_POST["title"] ?? "");
$artist = trim($_POST["artist"] ?? "");
$gradientColor = $_POST["gradient_color"];


// Vérifier que les champs sont remplis
if ($title === "" || $artist === "") {

    echo json_encode([
        "success" => false,
        "message" => "Remplis tous les champs"
    ]);

    exit;
}


// Vérifier que l'image a été envoyée
if (!isset($_FILES["cover"]) || $_FILES["cover"]["error"] !== UPLOAD_ERR_OK) {

    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de l'envoi de l'image"
    ]);

    exit;
}


// Limiter la taille à 5 Mo
if ($_FILES["cover"]["size"] > 5 * 1024 * 1024) {

    echo json_encode([
        "success" => false,
        "message" => "L'image est trop volumineuse"
    ]);

    exit;
}


// Vérifier le type de l'image
$finfo = new finfo(FILEINFO_MIME_TYPE);

$type = $finfo->file($_FILES["cover"]["tmp_name"]);


if ($type === "image/jpeg") {

    $extension = "jpg";

} elseif ($type === "image/png") {

    $extension = "png";

} elseif ($type === "image/webp") {

    $extension = "webp";

} else {

    echo json_encode([
        "success" => false,
        "message" => "Format d'image non autorisé"
    ]);

    exit;
}


// Créer un nom unique pour éviter les doublons
$nomImage = uniqid("album_") . "." . $extension;


// Chemin du dossier et chemin à enregistrer dans MySQL
$dossier = __DIR__ . "/asset/covers/";

$cover_path = "asset/covers/" . $nomImage;


// Vérifier que le dossier existe
if (!is_dir($dossier)) {

    echo json_encode([
        "success" => false,
        "message" => "Le dossier covers n'existe pas"
    ]);

    exit;
}


// Enregistrer l'image dans le dossier
if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $dossier . $nomImage)) {

    echo json_encode([
        "success" => false,
        "message" => "Impossible d'enregistrer l'image"
    ]);

    exit;
}


// Ajouter l'album dans MySQL
try {

    $sql = "INSERT INTO albums (title, artist, cover_path,gradient_color)
            VALUES (:title, :artist, :cover_path, :gradient_color)";

    $request = $pdo->prepare($sql);

    $request->execute([
        "title" => $title,
        "artist" => $artist,
        "cover_path" => $cover_path,
        "gradient_color" => $gradientColor
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Album créé avec succès !"
    ]);

} catch (PDOException $error) {

    // Supprimer l'image si MySQL n'a pas fonctionné
    unlink($dossier . $nomImage);

    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de l'enregistrement de l'album"
    ]);

}

?>

