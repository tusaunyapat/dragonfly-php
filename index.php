<?php
session_start(); // Start a session to keep the user logged in

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the entered password from the login form
    $entered_password = $_POST["password"];

    // Retrieve the stored hashed password (for demonstration, we're using a file)
    $stored_hashed_password = file_get_contents("hashed_password.txt");

    // Verify the entered password against the stored hashed password
    if (password_verify($entered_password, $stored_hashed_password)) {
        $_SESSION["logged_in"] = true; // Store login status in session
        header("Location: manage.php"); // Redirect to protected page
        exit();
    } 
}
?>
<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Product Filter</title>
   <!-- Bootstrap (optional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=Noto+Serif+Thai:wght@100..900&display=swap" rel="stylesheet">
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- DaisyUI (depends on Tailwind) -->
<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />


</head>

<style>
    body {
            font-family: 'IBM Plex Sans Thai', 'Noto Serif Thai', sans-serif;
            background-color: transparent !important;
    }

    .dark body {
        background-color: transparent !important; /* Dark background for dark mode */
    }
</style>
<body data-theme="bumblebee" class="">

<div class="relative">
<?php include './components/hero.php'; ?>
</div>
<div class="container min-h-screen">
   
    <p id="start" class="text-3xl lg:text-5xl w-full text-center text-yellow-500 py-4 pt-12 mt-16">สินค้าของเรา</p>
    <p class="text-lg w-full text-start text-yellow-500 pb-4">ค้นหาสินค้าได้ที่นี่</p>

    <!-- Search & Filter Form -->
    <form id="filterForm" class="mb-3">
        <input type="text" id="search" class="form-control mb-2" placeholder="ค้นหาสินค้า...">
        <div class="flex flex-row gap-2 items-center">
            <select id="category" class="form-select ">
                <option value="">ทั้งหมด</option>
            </select>
            <button type="submit" class="btn btn-sm p-2 btn-outline btn-warning">ค้นหา</button>
        </div>
    </form>

    <!-- Product List -->
    <div id="productGrid" class="row"></div>

    
    <div class="fixed bottom-20 right-10 " id="lineofficial">
       
        
    </div>
    <!-- Product Modal -->
    <div
        id="productModal"
        class="p-0 overflow overflow-y-auto fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-[99999] transition-all duration-300 ease-out "
        >
        <div class=" overflow overflow-y-auto  p-4 bg-white rounded-lg max-h-[70vh] lg:min-h-[40vh] lg:max-h-[80vh] max-w-[80vw] min-w-[75vw] lg:min-w-[50vw] lg:max-w-[70vw] relative ">
            <!-- Close Button -->
            <button
                id="modalClose"
                class="absolute top-2 right-2 text-gray-500 hover:text-black text-3xl"
            >
                &times;
            </button>

            <div class="flex flex-col md:flex-row  gap-4 py-2 h-full justify-start md:justify-center max-h-[70vh] lg:min-h-[40vh] lg:max-h-[80vh] max-w-[80vw] min-w-[75vw] lg:min-w-[50vw] lg:max-w-[70vw]">
                <!-- Left: Image Carousel -->
                <div class="w-full md:w-1/2 rounded-lg relative " >
                    <div class="overflow-x-auto snap-x snap-mandatory h-full w-full">
                        <div id="modalCarousel" class="flex flex-nowrap overflow-y-none h-full">
                            <!-- Images will be injected here -->
                        </div>
                    </div>
                </div>

                

                <!-- Right: Product Details -->
                <div class=" w-full md:w-1/2 flex flex-col py-2 ">
                    <!-- Top: Name + Category + Price -->
                    <div class="flex flex-wrap justify-between items-center mb-3 w-full">
                        <div class="flex items-center gap-2">
                            <h2 id="modalProductName" class="text-xl font-bold"></h2>
                            <span
                                id="modalProductCategory"
                                class="inline-block px-3 py-1 bg-yellow-400 text-black rounded-full text-sm lg:text-md"
                            ></span>
                        </div>
                        <p id="modalProductPrice" class="text-lg font-semibold text-green-700"></p>
                    </div>

                    <!-- Other Info -->
                    <div class="space-y-2 w-full h-full">
                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Brand:</h4>
                            <p id="modalProductBrand" class="text-sm lg:text-md text-gray-700 break-words"></p>
                        </div>

                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Description:</h4>
                            <p id="modalProductDescription" class="text-sm lg:text-md text-gray-600 break-words w-full"></p>
                        </div>

                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Details:</h4>
                            <p id="modalProductDetail" class="text-sm lg:text-md text-gray-600 break-words w-full"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include './components/footer.php'; ?>


<script src="script/filterProduct.js"></script>
<script src="script/getCategories.js"></script>


</body>
</html>
