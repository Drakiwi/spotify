
const listeMusiques = document.getElementById("listeMusiques");
const modeleMusique = document.getElementById("modeleMusique");
const lecteurAudio = document.getElementById("lecteurAudio");
const boutonPlayPause = document.getElementById("boutonPlayPause");
const imagePlayPause = document.getElementById("imagePlayPause");
const progression = document.getElementById("progression");
const boutonPrecedent = document.getElementById("previous");
const boutonSuivant = document.getElementById("next");
const boutonShuffle = document.getElementById("shuffle");
const volumeSlider = document.getElementById("volume");

if (boutonShuffle) {
    boutonShuffle.addEventListener("click", () => {
        shuffleActif = !shuffleActif;
        boutonShuffle.style.opacity = shuffleActif ? "1" : "0.5";
    });
}

// === GESTION DU VOLUME ===
if (volumeSlider) {
    volumeSlider.addEventListener("input", () => {
        lecteurAudio.volume = volumeSlider.value / 100;
    });
}

// === NAVIGATION ENTRE LES MORCEAUX ===
let shuffleActif = false;

function morceauSuivant() {
    if (musiques.length === 0) return;
    if (shuffleActif) {
        indexActuel = Math.floor(Math.random() * musiques.length);
    } else {
        indexActuel = (indexActuel + 1) % musiques.length;
    }
    lecteurAudio.src = musiques[indexActuel].file_path;
    lecteurAudio.play();
}
function morceauPrecedent() {
    if (musiques.length === 0) return;
    indexActuel = (indexActuel - 1 + musiques.length) % musiques.length;
    lecteurAudio.src = musiques[indexActuel].file_path;
    lecteurAudio.play();
}
if (boutonPrecedent) boutonPrecedent.addEventListener("click", morceauPrecedent);
if (boutonSuivant) boutonSuivant.addEventListener("click", morceauSuivant);

let musiques = [];
let indexActuel = 0;

fetch("get_songs.php")
    .then(response => response.json())
    .then(data => {
        musiques = data;
        listeMusiques.innerHTML = "";

        data.forEach((musique, index) => {

            // On copie notre carte
            const carte = modeleMusique.content.firstElementChild.cloneNode(true);
 
            // On remplit notre carte avec MySQL
            carte.querySelector("img").src = musique.cover_path;

            carte.querySelector("h3").textContent = musique.title;

            carte.querySelector("p").textContent = musique.artist;

            carte.addEventListener("click", () => {
                indexActuel = index;
                lecteurAudio.src = musique.file_path;
                lecteurAudio.play();
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

            data.forEach(musique => {

                // Copier notre carte
                const carte = modeleMusique.content.firstElementChild.cloneNode(true);

                // Remplir les informations
                carte.querySelector("img").src = musique.cover_path;
                carte.querySelector("h3").textContent = musique.title;
                carte.querySelector("p").textContent = musique.artist;

                // Lancer la musique au clic
                carte.addEventListener("click", () => {

                    lecteurAudio.src = musique.file_path;
                    lecteurAudio.play();

                });

                // Ajouter la carte à la page album
                musiquesAlbum.appendChild(carte);

            });

        });

}