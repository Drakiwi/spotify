const listeMusiques = document.getElementById("listeMusiques");
const modeleMusique = document.getElementById("modeleMusique");
const lecteurAudio = document.getElementById("lecteurAudio");



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