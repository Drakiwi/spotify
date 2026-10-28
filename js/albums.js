
const listeAlbums = document.getElementById("listeAlbums");
const modeleAlbum = document.getElementById("modeleAlbum");


fetch("get_albums.php")
    .then(response => response.json())
    .then(data => {

        
        listeAlbums.innerHTML = "";

        
        data.forEach(album => {

           
            const carte = modeleAlbum.content.firstElementChild.cloneNode(true);

           
            const image = carte.querySelector("img");
            const titre = carte.querySelector("h2");

           
            image.src = album.cover_path;
            titre.textContent = album.title;

           
            listeAlbums.appendChild(carte);

        });

    })
    .catch(error => {
        console.error("Erreur lors du chargement des albums :", error);
    });
