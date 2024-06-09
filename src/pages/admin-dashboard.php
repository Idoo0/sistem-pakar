<?php
    include '../../config.php';
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header("Location: ../auth/login.php");
        exit(); // Terminate script execution after the redirect
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
            <a href="add-cafe.html" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add New Cafe</a>
        </div>
        
        <!-- Table -->
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Cafe Name</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Distance</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Image</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Details</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row -->
                    <tr class="hover:bg-gray-200">
                        <td class="w-1/6 text-left py-3 px-4">Cafe A</td>
                        <td class="w-1/6 text-left py-3 px-4">20km</td>
                        <td class="w-1/6 text-left py-3 px-4">30k</td>
                        <td class="w-1/6 text-left py-3 px-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="showImageModal('../../assets/img/cafe.jpeg')">View Image</button>
                        </td>
                        <td class="w-1/6 text-left py-3 px-4">
                            <button class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600" onclick="showDetailsModal('Cafe A', 'Free WiFi, Parking, Outdoor Seating', 'Jl. Kleak bahu malalayang manado')">
                                See Details
                            </button>
                        </td>
                        <td class="w-1/6 text-left py-3 px-4 flex space-x-2">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 8H7a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v7m-2 7h-4v-4h-2" />
                                </svg>
                                Edit
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                    <!-- More rows can be added similarly -->
                </tbody>
                <tbody>
                    <!-- Example Row -->
                    <tr class="hover:bg-gray-200">
                        <td class="w-1/6 text-left py-3 px-4">Cafe A</td>
                        <td class="w-1/6 text-left py-3 px-4">20km</td>
                        <td class="w-1/6 text-left py-3 px-4">30k</td>
                        <td class="w-1/6 text-left py-3 px-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="showImageModal('../../assets/img/cafe.jpeg')">View Image</button>
                        </td>
                        <td class="w-1/6 text-left py-3 px-4">
                            <button class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600" onclick="showDetailsModal('Cafe A', 'Free WiFi, Parking, Outdoor Seating', 'Jl. Kleak bahu malalayang manado')">
                                See Details
                            </button>
                        </td>
                        <td class="w-1/6 text-left py-3 px-4 flex space-x-2">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 8H7a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v7m-2 7h-4v-4h-2" />
                                </svg>
                                Edit
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                    <!-- More rows can be added similarly -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="absolute top-0 right-0 m-4">
            <button class="text-white" onclick="hideDetailsModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <p class="text-sm font-medium">Facilities: 
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
                </p>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex items-center justify-center h-full">
            <img id="modalImage" src="" alt="Cafe Image" class="max-w-full max-h-full">
        </div>
    </div>

    <script>
        function showDetailsModal(name, facilities, address) {
            document.getElementById('cafeName').textContent = name;
            //document.getElementById('facilities').textContent = facilities;
            document.getElementById('address').textContent = address;
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function hideDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            // Clearing fields when modal is hidden to avoid previous data showing up
            document.getElementById('cafeName').textContent = '';
            document.getElementById('facilities').textContent = '';
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
    </script>
</body>
</html>
