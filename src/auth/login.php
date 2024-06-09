<?php
    require '../../config.php';
    session_start();
   
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['email'];
            header('Location: ../pages/admin-dashboard.php');
        } else {
            echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../../dist/output.css" rel="stylesheet" />
    <link href="../styles/style.css" rel="stylesheet" />
    <link href="../../assets/ico/coffee-icon.png" rel="icon">
    <style>
        body {
            background-color: #352D29;
        }
        .text-white {
            color: white;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen flex-col">
    <div class="text-center mb-6">
        <img src="../../assets/ico/coffee-icon.png" alt="Coffee Icon" class="h-16 w-16 mx-auto">
        <h1 class="text-4xl font-bold text-white mt-2">COFFEE!!</h1>
    </div>
    <div class="bg-[#535050] p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-white text-center">Login</h2>
        <form action="#" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-white">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-white">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <button type="submit" name="submit" class="w-full px-3 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
