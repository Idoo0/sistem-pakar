<?php
require '../../config.php';
include '../../controller/cafeController.php';
session_start();

$kafe = read();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit(); // Terminate script execution after the redirect
}
if (isset($_POST["submit"])) {

    if (create($_POST) > 0) {
        echo "
        <script>
          alert('data berhasil ditambahkan');
          document.location.href='admin-dashboard.php';

    } else {
        echo "
        <script>
          alert('data gagal ditambahkan');
          document.location.href='admin-dashboard.php';
        </script>
      ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../../dist/output.css" rel="stylesheet" />
    <link href="../styles/style.css" rel="stylesheet" />
    <link href="../../assets/ico/coffee-icon.png" rel="icon">
</head>

<body class="bg-gray-100 min-h-screen p-6">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center py-4">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <button onclick="showAddModal()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add
                New Cafe</button>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Kafe</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Jarak</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Fasilitas</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Keindahan</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Segi Rasa</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Detail Fasilitas</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Gambar</th>
                        <th class="w-1/9 text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kafe as $k): ?>
                        <!-- Example Row -->
                        <tr class="hover:bg-gray-200">
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["namaKafe"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["jarak"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["harga"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["fasilitas"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["keindahan"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <?= $k["segiRasa"] ?>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <button class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600"
                                    onclick="showDetailsModal('<?= $k['namaKafe'] ?>', <?= $k['hasWifi'] ?>, <?= $k['hasPermainan'] ?>, <?= $k['hasBuku'] ?>, 'Jl. Dahlia Kleak Malalayang Bahu Manado')">
                                    Facilities
                                </button>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                    onclick="showImageModal('../../assets/img/cafe.jpeg')">
                                    View
                                </button>
                            </td>
                            <td class="w-1/9 text-left py-3 px-4 flex space-x-2">
                                <button
                                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12H9m4 8H7a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v7m-2 7h-4v-4h-2" />
                                    </svg>
                                    Edit
                                </button>
                                <a href="../../controller/delete.php?id=<?= $k["id"]?>">
                                    <button
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Delete
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Cafe Modal -->
    <div id="addCafeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="absolute top-0 right-0 m-4">
            <button class="text-white" onclick="hideAddModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">Add New Cafe</h2>
            <form id="addCafeForm" method="POST" action="#">
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-black-700">Nama</label>
                    <input type="text" id="nama" name="nama"
                        class="px-2 py-1 mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="jarak" class="block text-sm font-medium text-black-700">Jarak</label>
                    <input type="number" id="jarak" name="jarak"
                        class="px-2 py-1 mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-black-700">Harga</label>
                    <input type="number" id="harga" name="harga"
                        class="px-2 py-1 mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="fasilitas" class="block text-sm font-medium text-black-700">Fasilitas</label>
                    <input type="number" id="fasilitas" name="fasilitas"
                        class="px-2 py-1 mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="keindahan" class="block text-sm font-medium text-black-700">Keindahan</label>
                    <input type="number" id="keindahan" name="keindahan"
                        class="px-2 py-1 mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="segiRasa" class="block text-sm font-medium text-black-700">Segi Rasa</label>
                    <input type="number" id="segiRasa" name="segiRasa"
                        class="mt-1 block w-full rounded-md border-black-300 shadow-sm" required>
                </div>
                <div class="mb-4 flex items-center gap-x-8">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-black-700">Wifi</label>
                        <input type="checkbox" id="hasWifi" name="hasWifi" class="rounded border-black-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-black-700">Permainan</label>
                        <input type="checkbox" id="hasPermainan" name="hasPermainan"
                            class="rounded border-black-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-black-700">Buku</label>
                        <input type="checkbox" id="hasBuku" name="hasBuku" class="rounded border-black-300 shadow-sm">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="hideAddModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancel</button>
                    <button type="submit" name="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="absolute top-0 right-0 m-4">
            <button class="text-white" onclick="hideDetailsModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">Cafe Details</h2>
            <div class="flex items-center mb-2">
                <p class="text-sm font-medium">Name: <span id="cafeName"></span></p>
            </div>
            <div class="flex items-center mb-2">
                <p class="text-sm font-medium">Facilities: <span id="facilities"></span></p>
            </div>
            <div class="flex items-center">
                <p class="text-sm font-medium">Address: <span id="address"></span></p>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="absolute top-0 right-0 m-4">
            <button class="text-white" onclick="hideImageModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex items-center justify-center h-full">
            <img id="modalImage" src="" alt="Cafe Image" class="max-w-full max-h-full">
        </div>
    </div>

    <script>
        function showDetailsModal(name, hasWifi, hasPermainan, hasBuku, address) {
            document.getElementById('cafeName').textContent = name;
            let facilities = '';
            if (hasWifi) facilities += `<div class="icon-wrapper"><span>📶</span><div class="icon-tooltip">Wifi</div></div>`;
            if (hasPermainan) facilities += `<div class="icon-wrapper"><span>🃏</span><div class="icon-tooltip">Permainan Kartu</div></div>`;
            if (hasBuku) facilities += `<div class="icon-wrapper"><span>📘</span><div class="icon-tooltip">Buku</div></div>`;
            document.getElementById('facilities').innerHTML = facilities;
            document.getElementById('address').textContent = address;
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function hideDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            // Clearing fields when modal is hidden to avoid previous data showing up
            document.getElementById('cafeName').textContent = '';
            document.getElementById('facilities').innerHTML = '';
            document.getElementById('address').textContent = '';
        }

        function showImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function hideImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = '';
        }

        function showAddModal() {
            document.getElementById('addCafeModal').classList.remove('hidden');
        }

        function hideAddModal() {
            document.getElementById('addCafeModal').classList.add('hidden');
            document.getElementById('addCafeForm').reset();
        }
    </script>
</body>

</html>