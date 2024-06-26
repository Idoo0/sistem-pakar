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

<body class="m-0 p-0">
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
    <div class="relative h-screen flex items-center justify-center bg-cover bg-center hero">
        <div class="relative z-20 max-w-5xl mx-auto px-4 flex items-center justify-between text-white">
            <div>
                <h1 class="text-7xl font-bold leading-none mb-4">Unleash Your Inner <br> Cafe Explorer</h1>
                <p class="text-2xl"><span class="text-red-600 font-bold">Discover</span> Your Next <br> Caffeinated
                    <span class="text-red-600 font-bold">Adventure</span>
                </p>
            </div>
            <!-- <div class="coffee-cup">
                <img src="../../assets/img/coffee-cup.png" alt="Coffee Cup" class="h-96">
            </div> -->
        </div>
    </div>

    <!-- Section 2 -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-5xl font-bold mb-8">Let's take a <span class="text-red-600">search</span> for your <span
                    class="text-red-600">cafe!</span></h2>
            <div class="flex justify-center items-center">
                <div class="coffee-cup">
                    <img src="../../assets/img/coffee-man.png" alt="Animated Man" class="h-64">
                </div>
                <div class="text-left">
                    <p class="text-2xl mb-4">Find the best cafes around you and explore new places to enjoy your meal.
                    </p>
                    <a href="cafe.html">
                        <button
                            class="px-6 py-3 bg-red-600 text-white text-xl font-semibold rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-50">
                            Search
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector(".mobile-menu-button");
        const mobileMenu = document.querySelector(".navigation-menu");

        mobileMenuButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });

        // Hide coffee-cup image on mobile screens
        function handleImageVisibility() {
            const coffeeCup = document.querySelector('.coffee-cup');
            if (window.innerWidth <= 768) {
                coffeeCup.style.display = 'none';
            } else {
                coffeeCup.style.display = 'block';
            }
        }

        // Hide coffee-cup image on mobile screens
        function handleImageVisibility() {
            const coffeeCup = document.querySelector('.coffee-cup');
            if (window.innerWidth <= 768) {
                coffeeCup.style.display = 'none';
            } else {
                coffeeCup.style.display = 'block';
            }
        }

        window.addEventListener('resize', handleImageVisibility);
        handleImageVisibility(); // Call initially

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