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
<html>
<head>
    <title>Sistem Pencarian Kafe</title>
</head>
<body>
    <h1>Sistem Pencarian Kafe</h1>

    <form method="post" action="">
        <label for="minJarak">Jarak Minimum:</label>
        <input type="number" name="minJarak" id="minJarak" required>
        <label for="maxJarak">Jarak Maksimum:</label>
        <input type="number" name="maxJarak" id="maxJarak" required>
        <br>
        <label for="minHarga">Harga Minimum:</label>
        <input type="number" name="minHarga" id="minHarga" required>
        <label for="maxHarga">Harga Maksimum:</label>
        <input type="number" name="maxHarga" id="maxHarga" required>
        <br>
        <label for="hasWifi">WiFi:</label>
        <select name="hasWifi" id="hasWifi" required>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
        <label for="hasPermainan">Permainan:</label>
        <select name="hasPermainan" id="hasPermainan" required>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
        <label for="hasBuku">Buku:</label>
        <select name="hasBuku" id="hasBuku" required>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
        <br>
        <button type="submit">Cari</button>
    </form>

    <?php if (!empty($searchResults)): ?>
        <h2>Hasil Pencarian</h2>
        <table border="1">
            <tr>
                <th>Nama Kafe</th>
                <th>Jarak</th>
                <th>Harga</th>
                <th>Fasilitas</th>
                <th>Keindahan</th>
                <th>Segi Rasa</th>
                <th>WiFi</th>
                <th>Permainan</th>
                <th>Buku</th>
                <th>Skor SAW</th>
                <th>Skor TOPSIS</th>
            </tr>
            <?php foreach ($searchResults as $index => $kafe): ?>
            <tr>
                <td><?= htmlspecialchars($kafe['namaKafe']) ?></td>
                <td><?= htmlspecialchars($kafe['jarak']) ?></td>
                <td><?= htmlspecialchars($kafe['harga']) ?></td>
                <td><?= htmlspecialchars($kafe['fasilitas']) ?></td>
                <td><?= htmlspecialchars($kafe['keindahan']) ?></td>
                <td><?= htmlspecialchars($kafe['segiRasa']) ?></td>
                <td><?= htmlspecialchars($kafe['hasWifi']) ? 'Ya' : 'Tidak' ?></td>
                <td><?= htmlspecialchars($kafe['hasPermainan']) ? 'Ya' : 'Tidak' ?></td>
                <td><?= htmlspecialchars($kafe['hasBuku']) ? 'Ya' : 'Tidak' ?></td>
                <td><?= htmlspecialchars($sawScores[$index]) ?></td>
                <td><?= htmlspecialchars($topsisScores[$index]) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
