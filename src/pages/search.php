<?php
require '../../config.php'; // Menghubungkan ke file config.php

// Fungsi untuk menghitung skor SAW
function calculateSAW($data, $weights) {
    $scores = [];
    foreach ($data as $row) {
        $score = 0;
        if (isset($row['jarak'])) $score += $row['jarak'] * $weights['jarak'];
        if (isset($row['harga'])) $score += $row['harga'] * $weights['harga'];
        if (isset($row['fasilitas'])) $score += $row['fasilitas'] * $weights['fasilitas'];
        if (isset($row['keindahan'])) $score += $row['keindahan'] * $weights['keindahan'];
        if (isset($row['segiRasa'])) $score += $row['segiRasa'] * $weights['segiRasa'];
        if (isset($row['hasWifi'])) $score += $row['hasWifi'] * $weights['hasWifi'];
        if (isset($row['hasPermainan'])) $score += $row['hasPermainan'] * $weights['hasPermainan'];
        if (isset($row['hasBuku'])) $score += $row['hasBuku'] * $weights['hasBuku'];
        $scores[] = $score;
    }
    return $scores;
}

// Fungsi untuk menghitung skor TOPSIS
function calculateTOPSIS($data, $weights) {
    $normalized = [];
    $idealBest = array_fill_keys(array_keys($weights), PHP_FLOAT_MIN);
    $idealWorst = array_fill_keys(array_keys($weights), PHP_FLOAT_MAX);

    // Normalisasi matriks
    foreach ($data as $row) {
        $normalizedRow = [];
        foreach ($weights as $key => $weight) {
            if (isset($row[$key])) {
                $normalizedValue = $row[$key] * $weight;
                $normalizedRow[$key] = $normalizedValue;
                if ($normalizedValue > $idealBest[$key]) {
                    $idealBest[$key] = $normalizedValue;
                }
                if ($normalizedValue < $idealWorst[$key]) {
                    $idealWorst[$key] = $normalizedValue;
                }
            }
        }
        $normalized[] = $normalizedRow;
    }

    // Hitung jarak dari solusi ideal terbaik dan terburuk
    $distances = [];
    foreach ($normalized as $row) {
        $distanceToBest = 0;
        $distanceToWorst = 0;
        foreach ($weights as $key => $weight) {
            if (isset($row[$key])) {
                $distanceToBest += pow($row[$key] - $idealBest[$key], 2);
                $distanceToWorst += pow($row[$key] - $idealWorst[$key], 2);
            }
        }
        $distanceToBest = sqrt($distanceToBest);
        $distanceToWorst = sqrt($distanceToWorst);
        $distances[] = $distanceToWorst / ($distanceToBest + $distanceToWorst);
    }

    return $distances;
}

// Contoh bobot untuk SAW dan TOPSIS
$weights = [
    'jarak' => 0.1,
    'harga' => 0.2,
    'fasilitas' => 0.15,
    'keindahan' => 0.15,
    'segiRasa' => 0.2,
    'hasWifi' => 0.1,
    'hasPermainan' => 0.05,
    'hasBuku' => 0.05
];

$searchResults = [];
$sawScores = [];
$topsisScores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $minJarak = $_POST['minJarak'];
    $maxJarak = $_POST['maxJarak'];
    $minHarga = $_POST['minHarga'];
    $maxHarga = $_POST['maxHarga'];
    $hasWifi = $_POST['hasWifi'];
    $hasPermainan = $_POST['hasPermainan'];
    $hasBuku = $_POST['hasBuku'];

    // Query untuk mendapatkan data berdasarkan filter
    $sql = "SELECT * FROM kafe WHERE jarak BETWEEN $minJarak AND $maxJarak AND harga BETWEEN $minHarga AND $maxHarga AND hasWifi = $hasWifi AND hasPermainan = $hasPermainan AND hasBuku = $hasBuku";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }



    // Hitung skor SAW dan TOPSIS untuk hasil pencarian
    $sawScores = calculateSAW($searchResults, $weights);
    $topsisScores = calculateTOPSIS($searchResults, $weights);
}
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
        <div class="flex flex-col items-center justify-center max-w-6xl w-full mx-auto p-4 space-y-4">
            <form class="bg-[#535050] p-4 rounded-lg w-full md:w-3/4 lg:w-1/2">
                <h1 class="text-2xl mb-4 text-center">Search ur Cafe!</h1>
                
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col md:flex-row md:gap-x-4 w-full">
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="harga" class="block text-lg mb-2 text-center md:text-left">Harga</label>
                            <select id="harga" name="harga" class="w-full p-2 mb-4 md:mb-0 rounded" style="color: black;">
                                <option value="" disabled selected hidden>Pilih</option>
                                <option value="<30k" style="color: black;">&lt;30k</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="fasilitas" class="block text-lg mb-2 text-center md:text-left">Fasilitas</label>
                            <select id="fasilitas" name="fasilitas" class="w-full p-2 mb-4 md:mb-0 rounded" style="color: black;">
                                <option value="" disabled selected hidden>Pilih</option>
                                <option value="wifi" style="color: black;">Wifi</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="jarak" class="block text-lg mb-2 text-center md:text-left">Jarak</label>
                            <select id="jarak" name="jarak" class="w-full p-2 rounded" style="color: black;">
                                <option value="" disabled selected hidden>Pilih</option>
                                <option value="<10km" style="color: black;">&lt;10km</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="harga" class="block text-lg mb-2 text-center md:text-left">Harga</label>
                            <select id="harga" name="harga" class="w-full p-2 mb-4 md:mb-0 rounded" style="color: black;">
                                <option value="" disabled selected hidden>Pilih</option>
                                <option value="<30k" style="color: black;">&lt;30k</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="fasilitas" class="block text-lg mb-2 text-center md:text-left">Fasilitas</label>
                            <select id="fasilitas" name="fasilitas" class="w-full p-2 mb-4 md:mb-0 rounded" style="color: black;">
                                <option value="" disabled selected hidden>Pilih</option>
                                <option value="wifi" style="color: black;">Wifi</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full p-2 bg-yellow-500 text-white rounded mt-4">Cari</button>
            </form>
        </div>
        
        
        
        
        
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold text-center mb-8">Pick ur Cafe!</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Cafe Card -->
                <div class="cafe-card rounded-lg text-center overflow-hidden">
                    <img src="../../assets/img/cafe.jpeg" alt="Kopiko Cafe">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">KOPIKO CAFE</h2>
                        <div class="flex justify-center space-x-4 mb-2">
                            <div class="icon-wrapper">
                                <span>📶</span>
                                <div class="icon-tooltip">Wi-Fi Available</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🔌</span>
                                <div class="icon-tooltip">Power Outlets</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>☕</span>
                                <div class="icon-tooltip">Outside Food Allowed</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🚬</span>
                                <div class="icon-tooltip">Smoking Area</div>
                            </div>
                        </div>
                        <p class="mb-4">30Km From Campus</p>
                        <button class="details-button bg-gray-700 text-white py-2 px-4 rounded">See Details!</button>
                    </div>
                </div>
                <div class="cafe-card rounded-lg text-center overflow-hidden">
                    <img src="../../assets/img/cafe.jpeg" alt="Kopiko Cafe">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">KOPIKO CAFE</h2>
                        <div class="flex justify-center space-x-4 mb-2">
                            <div class="icon-wrapper">
                                <span>📶</span>
                                <div class="icon-tooltip">Wi-Fi Available</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🔌</span>
                                <div class="icon-tooltip">Power Outlets</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>☕</span>
                                <div class="icon-tooltip">Outside Food Allowed</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🚬</span>
                                <div class="icon-tooltip">Smoking Area</div>
                            </div>
                        </div>
                        <p class="mb-4">30Km From Campus</p>
                        <button class="details-button bg-gray-700 text-white py-2 px-4 rounded">See Details!</button>
                    </div>
                </div>
                <div class="cafe-card rounded-lg text-center overflow-hidden">
                    <img src="../../assets/img/cafe.jpeg" alt="Kopiko Cafe">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">KOPIKO CAFE</h2>
                        <div class="flex justify-center space-x-4 mb-2">
                            <div class="icon-wrapper">
                                <span>📶</span>
                                <div class="icon-tooltip">Wi-Fi Available</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🔌</span>
                                <div class="icon-tooltip">Power Outlets</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>☕</span>
                                <div class="icon-tooltip">Outside Food Allowed</div>
                            </div>
                            <div class="icon-wrapper">
                                <span>🚬</span>
                                <div class="icon-tooltip">Smoking Area</div>
                            </div>
                        </div>
                        <p class="mb-4">30Km From Campus</p>
                        <button class="details-button bg-gray-700 text-white py-2 px-4 rounded">See Details!</button>
                    </div>
                </div>
                <!-- Add more cards as needed -->
            </div>
        </div>
    </main>

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
    </script>
</body>

</html>
