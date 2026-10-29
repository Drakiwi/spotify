
const listeMusiques = document.getElementById("listeMusiques");
const modeleMusique = document.getElementById("modeleMusique");
const lecteurAudio = document.getElementById("lecteurAudio");
const boutonPlayPause = document.getElementById("boutonPlayPause");
const imagePlayPause = document.getElementById("imagePlayPause");
const progression = document.getElementById("progression");
const boutonNext = document.getElementById("next");
const boutonPrevious = document.getElementById("previous");

let listeLecture = [];
let musiqueActuelle = 0;

function jouerMusique(index) {

    musiqueActuelle = index;

    lecteurAudio.src = listeLecture[musiqueActuelle].file_path;

    lecteurAudio.play();

}

fetch("get_songs.php")
    .then(response => response.json())
    .then(data => {

        listeMusiques.innerHTML = "";

        data.forEach((musique, index) => {

            // On copie notre carte
            const carte = modeleMusique.content.firstElementChild.cloneNode(true);
 
            // On remplit notre carte avec MySQL
            carte.querySelector("img").src = musique.cover_path;

            carte.querySelector("h3").textContent = musique.title;

            carte.querySelector("p").textContent = musique.artist;

           carte.addEventListener("click", () => {

                listeLecture = data;

                jouerMusique(index);

            });
            listeMusiques.appendChild(carte);

        });

    });

    boutonPlayPause.addEventListener("click", () => {

    console.log("Le bouton a été cliqué !");

    console.log("Musique :", lecteurAudio.getAttribute("src"));

    if (lecteurAudio.paused) {

     
        lecteurAudio.play();

    } else {

        
        lecteurAudio.pause();

    }

});

// Quand la musique démarre
lecteurAudio.addEventListener("play", () => {
    imagePlayPause.src = "asset/pause.svg";
});

// Quand la musique est en pause
lecteurAudio.addEventListener("pause", () => {
    imagePlayPause.src = "asset/play.svg";
});

lecteurAudio.addEventListener("timeupdate", () => {

    if (lecteurAudio.duration) {

        progression.value = (lecteurAudio.currentTime / lecteurAudio.duration) * 100;

    }

});

const musiquesAlbum = document.getElementById("musiquesAlbum");

function afficherMusiquesAlbum(albumId) {

    fetch("get_songs.php?album_id=" + albumId)
        .then(response => response.json())
        .then(data => {

            musiquesAlbum.innerHTML = "";

            data.forEach((musique, index) => {

                // Copier notre carte
                const carte = modeleMusique.content.firstElementChild.cloneNode(true);

                // Remplir les informations
                carte.querySelector("img").src = musique.cover_path;
                carte.querySelector("h3").textContent = musique.title;
                carte.querySelector("p").textContent = musique.artist;

                // Lancer la musique au clic
               carte.addEventListener("click", () => {

                    listeLecture = data;

                    jouerMusique(index);

                });

                // Ajouter la carte à la page album
                musiquesAlbum.appendChild(carte);

            });

        });

}



// Bouton suivant
boutonNext.addEventListener("click", () => {

    if (listeLecture.length === 0) {
        return;
    }

    musiqueActuelle += 1;

    if (musiqueActuelle >= listeLecture.length) {
        musiqueActuelle = 0;
    }

    jouerMusique(musiqueActuelle);

});


// Bouton précédent
boutonPrevious.addEventListener("click", () => {

    if (listeLecture.length === 0) {
        return;
    }

    musiqueActuelle -= 1;

    if (musiqueActuelle < 0) {
        musiqueActuelle = listeLecture.length - 1;
    }

    jouerMusique(musiqueActuelle);

});