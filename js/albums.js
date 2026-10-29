
const listeAlbums = document.getElementById("listeAlbums");
const modeleAlbum = document.getElementById("modeleAlbum");
const sectionAccueil = document.getElementById("home");
const pageAlbum = document.getElementById("pageAlbum");
const titreAlbum = document.getElementById("titreAlbum");
const retourAccueil = document.getElementById("retourAccueil");


fetch("get_albums.php")
    .then(response => response.json())
    .then(data => {

        listeAlbums.innerHTML = "";

        data.forEach(album => {

            // Copier notre carte HTML
            const carte = modeleAlbum.content.firstElementChild.cloneNode(true);

            // Récupérer les éléments
            const image = carte.querySelector("img");
            const titre = carte.querySelector("h2");

            // Remplir avec les données MySQL
            image.src = album.cover_path;
            titre.textContent = album.title;

            // Quand on clique sur un album
            carte.addEventListener("click", () => {

                // Changer l'URL sans recharger la page
                window.history.pushState({}, "", "index.php?album_id=" + album.id);

                // Cacher l'accueil
                sectionAccueil.style.display = "none";

                // Afficher la page album
                pageAlbum.style.display = "block";

                // Afficher le titre de l'album
                titreAlbum.textContent = album.title;

                // Afficher les musiques de cet album
                afficherMusiquesAlbum(album.id);

            });

            // Ajouter la carte à la liste des albums
            listeAlbums.appendChild(carte);

        });

    })
    .catch(error => {
        console.error("Erreur lors du chargement des albums :", error);
    });


// Bouton Retour
retourAccueil.addEventListener("click", () => {

    window.history.pushState({}, "", "index.php");

    // Cacher la page album
    pageAlbum.style.display = "none";

    // Afficher l'accueil
    sectionAccueil.style.display = "block";

});
