<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css"
      rel="stylesheet"
      type="text/css"
    />
  </head>
  <body class="p-6 bg-gray-100" data-theme="bumblebee">
    <!-- MANAGE PRODUCT -->
   <?php include "components/contact.php" ?>
   <?php include "components/socialmedia.php" ?>
   <?php include "components/category.php" ?>
   <?php include "components/product.php" ?>

   
    <script src="script/create-update-category.js"></script>
    <script src="script/create-update-socialmedia.js"></script>
    <script src="script/create-update-contact.js"></script>
    <script src="script/create-update-product.js"></script>
  </body>
</html>
