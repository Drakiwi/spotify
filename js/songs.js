
const listeMusiques = document.getElementById("listeMusiques");
const modeleMusique = document.getElementById("modeleMusique");
const lecteurAudio = document.getElementById("lecteurAudio");
const boutonPlayPause = document.getElementById("boutonPlayPause");
const imagePlayPause = document.getElementById("imagePlayPause");
const progression = document.getElementById("progression");

fetch("get_songs.php")
    .then(response => response.json())
    .then(data => {

        listeMusiques.innerHTML = "";

        data.forEach(musique => {

            // On copie notre carte
            const carte = modeleMusique.content.firstElementChild.cloneNode(true);
 
            // On remplit notre carte avec MySQL
            carte.querySelector("img").src = musique.cover_path;

            carte.querySelector("h3").textContent = musique.title;

            carte.querySelector("p").textContent = musique.artist;

            carte.addEventListener("click", () => {

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
    imagePlayPause.src = "asset/pause.png";
});

// Quand la musique est en pause
lecteurAudio.addEventListener("pause", () => {
    imagePlayPause.src = "asset/jouer.svg";
});

lecteurAudio.addEventListener("timeupdate", () => {

    if (lecteurAudio.duration) {

        progression.value = (lecteurAudio.currentTime / lecteurAudio.duration) * 100;

    }

});