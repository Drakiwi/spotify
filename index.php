

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify</title>

    <link rel="stylesheet" href="./src/output.css">
    <script src="./js/songs.js" defer></script>
    <script src="./js/albums.js" defer></script>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="./style.css">

</head>

<body class="flex flex-col bg-[#0D0D0C] h-screen overflow-hidden">


    <!-- HEADER -->
    <header>
        <nav class="seach bg-[#0D0D0C] flex  justify-center  p-4  relative"> 
            
            <a href="import.php" class="text-white bg-[#242320] right-40 absolute mt-2 text-2xl px-5 h-14 rounded-3xl flex items-center justify-center border-[#D8B875] border-1 cursor-pointer hover:bg-[#34332F] transition border-1 border-transparent hover:border-[#D8B875] transition-colors duration-300">
                <img src="asset/icons/import.svg" class="">
            </a>

            <div class="bg-[#242320] rounded-4xl p-5  w-full max-w-[800px] justify-center flex flex-col border-[#D8B875] border-0"> 
                <img src="asset/icons/search.svg" alt="search" class="size-8"> 
            </div> 
        </nav>

        
    </header>

    <!-- MAIN -->
    <main class="flex w-full gap-3 p-3 flex-1 min-h-0 overflow-hidden custom-scrollbar " >

        <!-- SECTION GAUCHE -->
        <section class="bg-[#242320] w-[300px] shrink-0 rounded-3xl p-3 overflow-y-auto">

            <h2 class="text-white text-xl font-bold mb-5">
                Playlist
            </h2>

            <div id="listeAlbums" class="playlist p-2 bg-[#242320] w-full gap-2 flex flex-col rounded-2xl mb-3">

                <!-- ALBUM 1 -->
                 <template id = "modeleAlbum">
                        <div class="album px-3 flex items-center gap-4 border-1 cursor-pointer hover:bg-[#34332F] transition border-1 border-transparent hover:border-[#D8B875] transition-colors duration-300 rounded-2xl ">
                            <img src="asset/1600w-uVEn4XbC1Ew.webp" class="size-20 rounded-2xl" alt="Album">
                            <h2 class="text-amber-50 font-bold">
                                titre de l'album
                            </h2>
                        </div>   
                </template>      

            </div>

        </section>

        <!-- SECTION DROITE HOME -->
        <section id="home" class="bg-[#242320] flex-1 min-w-0 rounded-3xl p-5 bg-linear-to-b from-[#5C4A2B] via-[#242320] to-[#242320] via-20% overflow-y-auto">

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

        <!-- PAGE ALBUM -->
        <section id="pageAlbum" class="hidden bg-[#242320] flex-1 min-w-0 rounded-3xl p-5" style="display: none;">

            <button id="retourAccueil" class="text-white mb-5 cursor-pointer flex">
                <img src="asset/icons/arrow-left.svg" alt=""> Retour
            </button>

            <h1 id="titreAlbum" class="text-white text-4xl font-bold">
            </h1>

            <!-- Les musiques de l'album seront affichées ici -->
            <div id="musiquesAlbum" class="flex flex-wrap gap-5 mt-5">
            </div>

        </section>

    </main>

    <!-- FOOTER / LECTEUR AUDIO -->
    <footer>
        <section id="play" class="bg-[#0D0D0C] p-3 relative">

            <div class="flex justify-center items-center gap-6">

            <!-- PREVIOUS -->
            <button id="previous" class="cursor-pointer hover:scale-110 transition-transform">
                <img src="asset/icons/previous.svg" alt="Previous" class="size-8">
            </button>

            <!-- PLAY / PAUSE -->
            <button id="boutonPlayPause" class="cursor-pointer hover:scale-110 transition-transform">
                <img id="imagePlayPause"
                    src="asset/play.svg"
                    alt="Play / Pause"
                    class="size-16">
            </button>

            <!-- NEXT -->
            <button id="next" class="cursor-pointer hover:scale-110 transition-transform">
                <img src="asset/icons/next.svg" alt="Next" class="size-8">
            </button>

            <!-- SHUFFLE -->
            <button id="shuffle" class="cursor-pointer hover:scale-110 transition-transform">
                <img src="asset/icons/shuffle.svg" alt="Shuffle" class="size-8">
            </button>

        </div>

            <div class="flex justify-center items-center mt-4">

                <input
                    type="range"
                    id="progression"
                    min="0"
                    max="100"
                    value="0"
                    class="w-[800px] accent-[#D8B875] cursor-pointer "
                >

            </div>

            <div style="position:fixed;right:24px;bottom:45px;display:flex;align-items:center;gap:8px;z-index:50;">
                <img src="asset/icons/volume.svg" alt="Volume" class="size-6">
                <input type="range" id="volume" min="0" max="100" value="100" class="w-[120px] accent-[#D8B875] cursor-pointer">
            </div>

        </section>
        <audio id="lecteurAudio"></audio>
    </footer>


</body>

</html>

