<?php
require '../../config.php';
include '../../controller/cafeController.php';

$kafe = read();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../../dist/output.css" rel="stylesheet" />
    <link href="../styles/style.css" rel="stylesheet" />
    <link href="../../assets/ico/coffee-icon.png" rel="icon">
</head>

<body class="m-0 p-0 bg-[#352D29] text-white">
    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-9999 p-1 text-white flex justify-center items-center">
        <div class="container mx-auto px-4 md:flex items-center gap-x-12">
            <!-- Logo -->
            <div class="flex items-center justify-between md:w-auto w-full gap-x-8">
                <a href="#" class="flex items-center py-5 px-2 text-white flex-1">
                    <img src="../../assets/ico/coffee-icon.png" alt="Coffee Icon" class="h-8 w-8">
                </a>
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>bars-3-bottom-left</title>
                            <g fill="none">
                                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Primary Navigation -->
            <div
                class="hidden md:flex md:flex-row flex-col items-center justify-start md:space-x-10 navigation-menu pb-3 md:pb-0 navigation-menu flex-1">
                <a href="index.php" class="py-2 px-3 block text-2xl">Home</a>
                <a href="cafe.php" class="py-2 px-3 block text-2xl">Cafe</a>
                <a href="search.php" class="py-2 px-3 block text-2xl">Search</a>
            </div>
            <!-- User Icon -->
            <div class="hidden md:flex items-center">
                <a href="../auth/login.php" class="flex items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A12.027 12.027 0 0112 15c2.45 0 4.785.73 6.879 2.074M12 9a4 4 0 100-8 4 4 0 000 8zm-9 12a9 9 0 1118 0H3z" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 pb-8 px-4">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold text-center mb-8">Pick ur Cafe!</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Cafe Card -->
                <?php foreach ($kafe as $k): ?>
                    <div class="cafe-card rounded-lg text-center overflow-hidden">
                        <img src="<?= '../../assets/img/cafe/' . $k["gambar"] ?>" alt="Kopiko Cafe">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2">
                                <?= $k["namaKafe"] ?>
                            </h2>
                            <div class="flex justify-center space-x-4 mb-2">
                                <?php if ($k["hasWifi"]): ?>
                                    <div class="icon-wrapper">
                                        <span>📶</span>
                                        <div class="icon-tooltip">Wi-Fi</div>
                                    </div>
                                <?php endif ?>
                                <?php if ($k["hasPermainan"]): ?>
                                    <div class="icon-wrapper">
                                        <span>🃏</span>
                                        <div class="icon-tooltip">Permainan Kartu</div>
                                    </div>
                                <?php endif ?>
                                <?php if ($k["hasBuku"]): ?>
                                    <div class="icon-wrapper">
                                        <span>📘</span>
                                        <div class="icon-tooltip">Buku</div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <p class="mb-4">
                                <?= $k["jarak"] . "km dari kampus" ?>
                            </p>
                            <button class="details-button bg-gray-700 text-white py-2 px-4 rounded"
                                onclick="showDetailsModal('<?= $k['namaKafe'] ?>', '<?= '../../assets/img/cafe/' . $k["gambar"] ?>', <?= $k['hasWifi'] ?>, <?= $k['hasPermainan'] ?>, <?= $k['hasBuku'] ?>, '<?= $k['alamat'] ?>')">See
                                Details!</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white text-black rounded-lg overflow-hidden w-11/12 md:w-1/2 flex flex-col items-center">
            <div class="p-4 text-center">
                <h2 id="cafeName" class="text-2xl font-bold mb-2"></h2>
                <div id="facilities" class="flex justify-center space-x-4 mb-2"></div>
                <p id="address" class="mb-4"></p>
                <button class="bg-gray-700 text-white py-2 px-4 rounded" onclick="hideDetailsModal()">Close</button>
            </div>
        </div>
    </div>



    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector(".mobile-menu-button");
        const mobileMenu = document.querySelector(".navigation-menu");

        mobileMenuButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });

        // Navbar transparency on scroll
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        function showDetailsModal(name, imageSrc, hasWifi, hasPermainan, hasBuku, address) {
            document.getElementById('cafeName').textContent = name;

            let facilities = '';
            if (hasWifi) facilities += `<div class="icon-wrapper"><span>📶</span><div class="icon-tooltip">Wi-Fi</div></div>`;
            if (hasPermainan) facilities += `<div class="icon-wrapper"><span>🃏</span><div class="icon-tooltip">Permainan Kartu</div></div>`;
            if (hasBuku) facilities += `<div class="icon-wrapper"><span>📘</span><div class="icon-tooltip">Buku</div></div>`;
            document.getElementById('facilities').innerHTML = facilities;

            document.getElementById('address').textContent = address;

            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function hideDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.getElementById('cafeName').textContent = '';
            document.getElementById('cafeImage').src = '';
            document.getElementById('facilities').innerHTML = '';
            document.getElementById('address').textContent = '';
        }
    </script>
</body>

</html>