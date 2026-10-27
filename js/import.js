const formImport = document.getElementById("formImport");
const statutImport = document.getElementById("statutImport");
const envoyerImport = document.getElementById("envoyerImport");
const titreMusique = document.getElementById("titreMusique");
const fichierMusique = document.getElementById("fichierMusique");
const selectAlbum = document.getElementById("selectAlbum");
const formAlbum = document.getElementById("formAlbum");
const statutAlbum = document.getElementById("statutAlbum");
const envoyerAlbum = document.getElementById("envoyerAlbum");

function afficherStatut(message, erreur = false) {
    statutImport.textContent = message;
    statutImport.className = erreur
        ? "rounded-lg bg-red-500/10 p-3 text-sm text-red-300"
        : "rounded-lg bg-[#D8B875]/10 p-3 text-sm text-[#D8B875]";
}

function afficherStatutAlbum(message, erreur = false) {
    statutAlbum.textContent = message;
    statutAlbum.className = erreur
        ? "rounded-lg bg-red-500/10 p-3 text-sm text-red-300"
        : "rounded-lg bg-[#D8B875]/10 p-3 text-sm text-[#D8B875]";
}

async function chargerAlbums() {
    const response = await fetch("get_albums.php");
    if (!response.ok) {
        return;
    }

    const albums = await response.json();
    selectAlbum.innerHTML = '<option value="">-- Choisir un album --</option>';

    albums.forEach(album => {
        const option = document.createElement("option");
        option.value = album.id;
        option.textContent = `${album.title} — ${album.artist}`;
        selectAlbum.appendChild(option);
    });
}

// Charger les albums au chargement de la page
chargerAlbums();

fichierMusique.addEventListener("change", () => {
    const fichier = fichierMusique.files[0];
    if (fichier && !titreMusique.value.trim()) {
        titreMusique.value = fichier.name.replace(/\.mp3$/i, "");
    }
});

formImport.addEventListener("submit", async event => {
    event.preventDefault();
    afficherStatut("Enregistrement en cours...");
    envoyerImport.disabled = true;

    try {
        const response = await fetch("upload_song.php", {
            method: "POST",
            body: new FormData(formImport)
        });
        const contenu = await response.text();
        let resultat;

        try {
            resultat = JSON.parse(contenu);
        } catch {
            throw new Error(`Le serveur a répondu avec une erreur HTTP ${response.status}. Vérifie les journaux PHP de WAMP.`);
        }

        if (!response.ok) {
            throw new Error(resultat.error || `L'import a échoué (HTTP ${response.status}).`);
        }

        formImport.reset();
        afficherStatut(resultat.message || "La musique a été importée avec succès.");
    } catch (error) {
        afficherStatut(error.message || "Une erreur inattendue a empêché l'import.", true);
    } finally {
        envoyerImport.disabled = false;
    }
});

formImport.addEventListener("invalid", event => {
    afficherStatut(`Vérifie le champ « ${event.target.labels?.[0]?.textContent.trim() || event.target.name} » puis réessaie.`, true);
}, true);

// --- CRÉATION D'ALBUM ---

formAlbum.addEventListener("submit", async event => {
    event.preventDefault();
    afficherStatutAlbum("Création en cours...");
    envoyerAlbum.disabled = true;

    try {
        const response = await fetch("create_album.php", {
            method: "POST",
            body: new FormData(formAlbum)
        });
        const contenu = await response.text();
        let resultat;

        try {
            resultat = JSON.parse(contenu);
        } catch {
            throw new Error(`Le serveur a répondu avec une erreur HTTP ${response.status}.`);
        }

        if (!response.ok) {
            throw new Error(resultat.error || `La création a échoué (HTTP ${response.status}).`);
        }

        // Recharger la liste des albums pour le formulaire d'import
        await chargerAlbums();
        formAlbum.reset();
        afficherStatutAlbum(resultat.message || "L'album a été créé avec succès.");
    } catch (error) {
        afficherStatutAlbum(error.message || "Une erreur inattendue a empêché la création.", true);
    } finally {
        envoyerAlbum.disabled = false;
    }
});

formAlbum.addEventListener("invalid", event => {
    afficherStatutAlbum(`Vérifie le champ « ${event.target.labels?.[0]?.textContent.trim() || event.target.name} » puis réessaie.`, true);
}, true);
