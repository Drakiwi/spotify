// Fichier: import.js

const selectAlbum = document.getElementById("selectAlbum");
const formAlbum = document.getElementById("formAlbum");
const statutAlbum = document.getElementById("statutAlbum");
const formImport = document.getElementById("formImport");
const statutImport = document.getElementById("statutImport");



// Récupérer les albums depuis MySQL
function chargerAlbums() {

    fetch("get_albums.php")
        .then(response => response.json())
        .then(data => {

            selectAlbum.innerHTML = "";

            data.forEach(album => {

                // Créer une option pour chaque album
                const option = document.createElement("option");

                option.value = album.id;
                option.textContent = album.title;

                selectAlbum.appendChild(option);

            });

        })
        .catch(error => {
            console.error("Erreur albums :", error);
        });

}


// Charger les albums au démarrage
chargerAlbums();


// Quand on envoie le formulaire de création d'album
formAlbum.addEventListener("submit", (event) => {

    // Empêcher le rechargement de la page
    event.preventDefault();

    // Récupérer les données du formulaire
    const formData = new FormData(formAlbum);

    statutAlbum.textContent = "Création en cours...";

    // Envoyer les informations à PHP
    fetch("create_album.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        // Afficher le message de PHP
        statutAlbum.textContent = data.message;

        if (data.success) {

            // Vider le formulaire
            formAlbum.reset();

            // Actualiser la liste des albums
            chargerAlbums();

        }

    })
    .catch(error => {

        console.error("Erreur :", error);

        statutAlbum.textContent = "Erreur lors de la création de l'album";

    });

});


formImport.addEventListener("submit", (event) => {

    event.preventDefault();

    const formData = new FormData(formImport);

    console.log("Album :", formData.get("album_id"));
    console.log("Titre :", formData.get("title"));
    console.log("Artiste :", formData.get("artist"));
    console.log("Pochette :", formData.get("cover"));
    console.log("Musique :", formData.get("audio"));

    statutImport.textContent = "Formulaire récupéré !";

});

formImport.addEventListener("submit", (event) => {

    event.preventDefault();

    const formData = new FormData(formImport);

    fetch("upload_song.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        statutImport.textContent = data.message;

        if (data.success) {
            formImport.reset();
        }

    });

});
