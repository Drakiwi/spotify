<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify - Importer</title>

    <link rel="stylesheet" href="./src/output.css">
    <script src="./js/import.js" defer></script>
</head>

<body class="flex flex-col min-h-screen bg-[#0D0D0C] bg-fixed bg-cover bg-center" style="background-image: url('asset/background.png');">

    <!-- HEADER -->
    <header>
        <nav class="bg-[#0D0D0C] flex justify-center">
            <div class="bg-[#242320] rounded-4xl p-5 w-full max-w-[800px] pt-4 mt-5 justify-between flex items-center">
                <a href="index.php">
                    <img src="asset/chercher.svg" alt="retour" class="size-7">
                </a>
                <h1 class="text-white text-xl font-bold">Importer</h1>
                <div class="w-7"></div>
            </div>
        </nav>
    </header>

    <!-- MAIN -->
    <main class="flex w-full gap-3 p-3 flex-1 justify-center">
        <section class="bg-[#242320] flex-1 min-w-0 rounded-3xl p-5 max-w-[800px]">

            <!-- FORMULAIRE CRÉER ALBUM -->
            <div id="formulaireAlbum" class="mb-8">
                <div class="max-h-[75vh] w-full overflow-y-auto rounded-2xl bg-[#181816] p-6 text-white shadow-2xl">
                    <form id="formAlbum" class="flex flex-col gap-4" enctype="multipart/form-data">
                        <h2 class="text-2xl font-bold">Créer un album</h2>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Titre de l'album
                            <input id="titreAlbum" name="title" type="text" maxlength="255" required
                                class="rounded-lg border border-white/10 bg-[#0D0D0C] p-3 text-white outline-none focus:border-[#D8B875]">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Artiste
                            <input id="artisteAlbum" name="artist" type="text" maxlength="255" required
                                class="rounded-lg border border-white/10 bg-[#0D0D0C] p-3 text-white outline-none focus:border-[#D8B875]">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Pochette (JPEG, PNG ou WebP)
                            <input id="pochetteAlbum" name="cover" type="file" accept="image/jpeg,image/png,image/webp" required
                                class="w-full cursor-pointer rounded-lg bg-[#0D0D0C] p-3 text-sm text-gray-400 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-[#D8B875] file:px-4 file:py-2 file:font-bold file:text-black hover:file:bg-[#D8B875]/80">
                        </label>

                        <p id="statutAlbum" role="status" aria-live="polite"></p>

                        <div class="flex justify-end gap-3">
                            <button id="envoyerAlbum" type="submit"
                                class="rounded-lg bg-[#D8B875] px-4 py-2 font-bold text-black transition hover:bg-[#D8B875]/80 disabled:cursor-not-allowed disabled:opacity-50">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FORMULAIRE IMPORTER -->
            <div id="formulaireImportContainer">
                <div class="max-h-[75vh] w-full overflow-y-auto rounded-2xl bg-[#181816] p-6 text-white shadow-2xl">
                    <form id="formImport" class="flex flex-col gap-4" enctype="multipart/form-data">
                        <h2 class="text-2xl font-bold">Importer une musique</h2>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Album
                            <select id="selectAlbum" name="album_id" required
                                class="rounded-lg border border-white/10 bg-[#0D0D0C] p-3 text-white outline-none focus:border-[#D8B875]">
                            </select>
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Titre
                            <input id="titreMusique" name="title" type="text" maxlength="255" required
                                class="rounded-lg border border-white/10 bg-[#0D0D0C] p-3 text-white outline-none focus:border-[#D8B875]">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Artiste
                            <input name="artist" type="text" maxlength="255" required
                                class="rounded-lg border border-white/10 bg-[#0D0D0C] p-3 text-white outline-none focus:border-[#D8B875]">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Pochette (JPEG, PNG ou WebP)
                            <input name="cover" type="file" accept="image/jpeg,image/png,image/webp" required
                                class="w-full cursor-pointer rounded-lg bg-[#0D0D0C] p-3 text-sm text-gray-400 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-[#D8B875] file:px-4 file:py-2 file:font-bold file:text-black hover:file:bg-[#D8B875]/80">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-300">
                            Fichier audio (MP3)
                            <input id="fichierMusique" name="audio" type="file" accept=".mp3,audio/mpeg" required
                                class="w-full cursor-pointer rounded-lg bg-[#0D0D0C] p-3 text-sm text-gray-400 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-[#D8B875] file:px-4 file:py-2 file:font-bold file:text-black hover:file:bg-[#D8B875]/80">
                        </label>

                        <p id="statutImport" role="status" aria-live="polite"></p>

                        <div class="flex justify-end gap-3">
                            <button id="envoyerImport" type="submit"
                                class="rounded-lg bg-[#D8B875] px-4 py-2 font-bold text-black transition hover:bg-[#D8B875]/80 disabled:cursor-not-allowed disabled:opacity-50">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </main>

</body>

</html>
