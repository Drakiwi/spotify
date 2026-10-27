
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify</title>

    <link rel="stylesheet" href="./src/output.css">
    <script src="./js/songs.js" defer></script>
</head>

<body class="flex flex-col min-h-screen bg-[#0D0D0C] bg-fixed bg-cover bg-center" style="background-image: url('asset/background.png');">

<audio id="lecteurAudio"></audio>

    <!-- HEADER -->
    <header>
        <a href="import.php"></a>
        <nav class="bg-[#0D0D0C] flex justify-center">

            <div class="bg-[#242320] rounded-4xl p-5 w-full max-w-[800px] pt-4 mt-5 justify-between flex items-center">
                <img src="asset/chercher.svg" alt="search" class="size-7">
                <div class="flex gap-2">
                    <a href="import.php" title="Créer un album"
                        class="cursor-pointer rounded-full border-2 border-[#D8B875] bg-transparent w-8 h-8 flex items-center justify-center text-sm font-bold text-[#D8B875] transition hover:bg-[#D8B875] hover:text-black">
                        +
                    </a>
                    <a href="import.php" title="Importer une musique"
                        class="cursor-pointer rounded-full border-2 border-[#D8B875] bg-transparent w-8 h-8 flex items-center justify-center text-sm font-bold text-[#D8B875] transition hover:bg-[#D8B875] hover:text-black">
                        📥
                    </a>
                </div>
            </div>

        </nav>
    </header>

    <!-- MAIN -->
    <main class="flex w-full gap-3 p-3 flex-1">

        <!-- SECTION GAUCHE -->
        <section class="bg-[#242320] w-[300px] shrink-0 rounded-3xl p-3">

            <h2 class="text-white text-xl font-bold mb-5">
                Playlist
            </h2>

            <div class="p-2 bg-[#242320] w-full gap-2 flex flex-col rounded-2xl mb-3">

                <!-- ALBUM 1 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 2 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 3 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 4 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 5 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 6 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 7 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

                <!-- ALBUM 8 -->
                <div class="px-3 flex items-center gap-4">
                    <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                    <h2 class="text-amber-50 font-bold">
                        titre de l'album
                    </h2>
                </div>

            </div>

        </section>

        <!-- SECTION DROITE HOME -->
        <section id="home" class="bg-[#242320] flex-1 min-w-0 rounded-3xl p-5">

            <h1 class="text-white text-4xl font-bold">
                Accueil
            </h1>

            <!-- RECOMMENDATIONS -->
            <div class="p-5">

                <h2 class="text-white text-2xl font-bold mb-5">
                    Recommended for you
                </h2>

                <!-- CONTENEUR DES MUSIQUES -->
                <div id="listeMusiques" class="flex flex-wrap gap-5">
                </div>

                <!-- UNE SEULE CARTE MODÈLE -->
                <template id="modeleMusique">

                    <div class="bg-[#242320] p-3 rounded-2xl w-44 cursor-pointer hover:bg-[#34332F] transition">

                        <img src="" alt="Pochette de musique"
                             class="w-full aspect-square object-cover rounded-xl mb-3">

                        <h3 class="text-white font-bold"></h3>

                        <p class="text-gray-400"></p>

                    </div>

                </template>

            </div>

        </section>

    </main>

    <!-- FOOTER / LECTEUR AUDIO -->
    <footer>

        <section id="play" class="bg-[#242320] p-5">
            <div></div>
        </section>

    </footer>

</body>

</html>
