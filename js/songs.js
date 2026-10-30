
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

const musiquesAlbum = document.getElementById("musiquesAlbum");

let listeLecture = [];
let indexActuel = 0;
let shuffleActif = false;


// FONCTION POUR JOUER UNE MUSIQUE
function jouerMusique(index) {

    indexActuel = index;

    lecteurAudio.src = listeLecture[indexActuel].file_path;

    lecteurAudio.play();

}


// CHARGER LES MUSIQUES DE L'ACCUEIL
fetch("get_songs.php")
    .then(response => response.json())
    .then(data => {

        listeMusiques.innerHTML = "";

        data.forEach((musique, index) => {

            const carte = modeleMusique.content.firstElementChild.cloneNode(true);

            carte.querySelector("img").src = musique.cover_path;
            carte.querySelector("h3").textContent = musique.title;
            carte.querySelector("p").textContent = musique.artist;

            carte.addEventListener("click", () => {

                listeLecture = data;

                jouerMusique(index);

            });

            listeMusiques.appendChild(carte);

        });

    })
    .catch(error => {
        console.error("Erreur chargement musiques :", error);
    });


// CHARGER LES MUSIQUES D'UN ALBUM
function afficherMusiquesAlbum(albumId) {

    fetch("get_songs.php?album_id=" + albumId)
        .then(response => response.json())
        .then(data => {

            musiquesAlbum.innerHTML = "";

            data.forEach((musique, index) => {

                const carte = modeleMusique.content.firstElementChild.cloneNode(true);

                carte.querySelector("img").src = musique.cover_path;
                carte.querySelector("h3").textContent = musique.title;
                carte.querySelector("p").textContent = musique.artist;

                carte.addEventListener("click", () => {

                    listeLecture = data;

                    jouerMusique(index);

                });

                musiquesAlbum.appendChild(carte);

            });

        })
        .catch(error => {
            console.error("Erreur chargement album :", error);
        });

}


// BOUTON SUIVANT
boutonSuivant.addEventListener("click", () => {

    if (listeLecture.length === 0) {
        return;
    }

    if (shuffleActif) {

        indexActuel = Math.floor(Math.random() * listeLecture.length);

    } else {

        indexActuel += 1;

        if (indexActuel >= listeLecture.length) {
            indexActuel = 0;
        }

    }

    jouerMusique(indexActuel);

});


// BOUTON PRÉCÉDENT
boutonPrecedent.addEventListener("click", () => {

    if (listeLecture.length === 0) {
        return;
    }

    indexActuel -= 1;

    if (indexActuel < 0) {
        indexActuel = listeLecture.length - 1;
    }

    jouerMusique(indexActuel);

});


// BOUTON SHUFFLE
boutonShuffle.style.opacity = "0.5";

boutonShuffle.addEventListener("click", () => {

    shuffleActif = !shuffleActif;

    if (shuffleActif) {
        boutonShuffle.style.opacity = "1";
    } else {
        boutonShuffle.style.opacity = "0.5";
    }

});


// VOLUME
volumeSlider.addEventListener("input", () => {

    lecteurAudio.volume = volumeSlider.value / 100;

});


// PLAY / PAUSE
boutonPlayPause.addEventListener("click", () => {

    if (lecteurAudio.getAttribute("src") === null) {
        return;
    }

    if (lecteurAudio.paused) {

        lecteurAudio.play();

    } else {

        lecteurAudio.pause();

    }

});


// CHANGER L'ICÔNE QUAND LA MUSIQUE DÉMARRE
lecteurAudio.addEventListener("play", () => {

    imagePlayPause.src = "asset/pause.svg";

});


// CHANGER L'ICÔNE QUAND LA MUSIQUE EST EN PAUSE
lecteurAudio.addEventListener("pause", () => {

    imagePlayPause.src = "asset/play.svg";

});


// ACTUALISER LA BARRE DE PROGRESSION
lecteurAudio.addEventListener("timeupdate", () => {

    if (lecteurAudio.duration) {

        progression.value = (lecteurAudio.currentTime / lecteurAudio.duration) * 100;

    }

});


// AVANCER OU RECULER DANS LA MUSIQUE
progression.addEventListener("input", () => {

    if (lecteurAudio.duration) {

        lecteurAudio.currentTime = (progression.value / 100) * lecteurAudio.duration;

    }

});

lecteurAudio.addEventListener("ended", () => {

    boutonSuivant.click();

});