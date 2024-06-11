<?php
require '../../config.php'; // Menghubungkan ke file config.php

// Fungsi untuk menghitung skor SAW
function calculateSAW($data, $weights)
{
    $scores = [];
    foreach ($data as $row) {
        $score = 0;
        if (isset($row['jarak']))
            $score += $row['jarak'] * $weights['jarak'];
        if (isset($row['harga']))
            $score += $row['harga'] * $weights['harga'];
        if (isset($row['fasilitas']))
            $score += $row['fasilitas'] * $weights['fasilitas'];
        if (isset($row['keindahan']))
            $score += $row['keindahan'] * $weights['keindahan'];
        if (isset($row['segiRasa']))
            $score += $row['segiRasa'] * $weights['segiRasa'];
        $scores[] = $score;
    }
    return $scores;
}

// Fungsi untuk menghitung skor TOPSIS
function calculateTOPSIS($data, $weights)
{
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
    try {
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

    } catch (Exception $e) {
        return $distances;
    }
}

// Contoh bobot untuk SAW dan TOPSIS
$weights = [
    'jarak' => 0.14,
    'harga' => 0.19,
    'fasilitas' => 0.29,
    'keindahan' => 0.29,
    'segiRasa' => 0.9
];

$searchResults = [];
$sawScores = [];
$topsisScores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $minJarak = $_POST['minJarak'];
    $maxJarak = $_POST['maxJarak'];
    $minHarga = $_POST['minHarga'];
    $maxHarga = $_POST['maxHarga'];

    // Query untuk mendapatkan data berdasarkan filter
    $sql = "SELECT * FROM kafe WHERE jarak BETWEEN $minJarak AND $maxJarak AND harga BETWEEN $minHarga AND $maxHarga";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
    <style>
        .tableHasilPerhitungan {
            margin-top: 20px;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
        }

        .tableHasilPerhitungan h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00;
        }

        .tableHasilPerhitungan table {
            width: 100%;
            border-collapse: collapse;
        }

        .tableHasilPerhitungan th,
        .tableHasilPerhitungan td {
            padding: 12px 15px;
            text-align: center;
        }

        .tableHasilPerhitungan th {
            background-color: #ffcc00;
            color: #2c2c2c;
        }

        .tableHasilPerhitungan tr:nth-child(even) {
            background-color: #383838;
        }

        .tableHasilPerhitungan tr:hover {
            background-color: #4d4d4d;
        }

        .tableHasilPerhitungan td {
            color: #ffffff;
        }
    </style>
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
                            d="M5.121 17.804A12.027 12.027 0 0112 15c2.45 0 4.785.73 6.879 2.074M12 9a4 4 0 100-8 4 4 0 000 8zm-9 15h18c.74 0 1.44-.27 2-.76A2.99 2.99 0 0021 21H3c-.74 0-1.44.27-2 .76A2.99 2.99 0 000 24c0-.74.27-1.44.76-2A2.99 2.99 0 003 21h18c.74 0 1.44-.27 2-.76A2.99 2.99 0 0021 21H3c-.74 0-1.44.27-2 .76A2.99 2.99 0 000 24c0-.74.27-1.44.76-2A2.99 2.99 0 003 21H21c.74 0 1.44-.27 2-.76A2.99 2.99 0 0024 21c0-.74-.27-1.44-.76-2A2.99 2.99 0 0021 21H3c-.74 0-1.44.27-2 .76A2.99 2.99 0 000 24c0-.74.27-1.44.76-2A2.99 2.99 0 003 21H21z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 p-10">
        <div class="container mx-auto">
            <h1 class="text-center text-4xl font-bold mb-8">Pencarian Cafe</h1>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg">
                <div class="mb-4">
                    <label for="minJarak" class="block text-sm font-medium text-gray-400 mb-2">Jarak Minimum (KM)</label>
                    <input type="number" id="minJarak" name="minJarak" class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-gray-500" required>
                </div>
                <div class="mb-4">
                    <label for="maxJarak" class="block text-sm font-medium text-gray-400 mb-2">Jarak Maximum (KM)</label>
                    <input type="number" id="maxJarak" name="maxJarak" class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-gray-500" required>
                </div>
                <div class="mb-4">
                    <label for="minHarga" class="block text-sm font-medium text-gray-400 mb-2">Harga Minimum (Rp)</label>
                    <input type="number" id="minHarga" name="minHarga" class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-gray-500" required>
                </div>
                <div class="mb-4">
                    <label for="maxHarga" class="block text-sm font-medium text-gray-400 mb-2">Harga Maximum (Rp)</label>
                    <input type="number" id="maxHarga" name="maxHarga" class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-gray-500" required>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-yellow-500 text-gray-900 py-2 px-4 rounded-lg font-medium hover:bg-yellow-600">Cari Cafe</button>
                </div>
            </form>

            <?php if (!empty($searchResults)): ?>
            <div class="container mx-auto">
                <h1 class="text-4xl font-bold text-center mb-8">Pick ur Cafe!</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Cafe Card -->
                    <?php foreach ($searchResults as $index => $k): ?>
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
        <?php else: ?>
            <div class="container mx-auto">
                <h1 class="text-4xl font-bold text-center mb-8">Cafe tidak ditemukan!</h1>
                <h3 class="text-2xl text-center mb-8">lakukan atau ulang pencarian</h3>

            </div>
        <?php endif; ?>

            <?php if (!empty($searchResults)) : ?>
                <div class="tableHasilPerhitungan">
                    <h2>Hasil Pencarian dan Perhitungan SAW dan TOPSIS</h2>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th>ID Cafe</th>
                                <th>Nama Cafe</th>
                                <th>Jarak (KM)</th>
                                <th>Harga (Rp)</th>
                                <th>Fasilitas</th>
                                <th>Keindahan</th>
                                <th>Segi Rasa</th>
                                <th>Skor SAW</th>
                                <th>Skor TOPSIS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $index => $result) : ?>
                                <tr>
                                    <td><?php echo $result['id']; ?></td>
                                    <td><?php echo $result['namaKafe']; ?></td>
                                    <td><?php echo $result['jarak']; ?></td>
                                    <td><?php echo $result['harga']; ?></td>
                                    <td><?php echo $result['fasilitas']; ?></td>
                                    <td><?php echo $result['keindahan']; ?></td>
                                    <td><?php echo $result['segiRasa']; ?></td>
                                    <td><?php echo $sawScores[$index]; ?></td>
                                    <td><?php echo $topsisScores[$index]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // JavaScript untuk mengelola mobile menu
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.navigation-menu').classList.toggle('hidden');
        });
    </script>
    
</body>

</html>
