const listeMusiques = document.getElementById("listeMusiques");
const modeleMusique = document.getElementById("modeleMusique");
const lecteurAudio = document.getElementById("lecteurAudio");

async function chargerMusiques() {
    const response = await fetch("get_songs.php");
    if (!response.ok) {
        throw new Error("Impossible de charger les musiques.");
    }

    const musiques = await response.json();
    listeMusiques.innerHTML = "";

    musiques.forEach(musique => {
        const carte = modeleMusique.content.firstElementChild.cloneNode(true);

        carte.querySelector("img").src = musique.cover_path;
        carte.querySelector("h3").textContent = musique.title;
        carte.querySelector("p").textContent = musique.artist;

        carte.addEventListener("click", () => {
            const cheminMusique = new URL(musique.file_path, document.baseURI).href;

            if (lecteurAudio.src === cheminMusique && !lecteurAudio.paused) {
                lecteurAudio.pause();
                return;
            }

            lecteurAudio.src = musique.file_path;
            lecteurAudio.play();
        });

        listeMusiques.appendChild(carte);
    });
}

chargerMusiques().catch(error => {
    listeMusiques.textContent = error.message;
});