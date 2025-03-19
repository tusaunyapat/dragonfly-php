$(document).ready(function () {
  let imageFiles = [];
  let existingImages = []; // To store the existing image URLs when editing a product

  function fetchCategories() {
    $.get("api/categories.php", function (data) {
      const categories = data.categories || [];
      $("#category").html(
        `<option value="">N/A</option>` +
          categories
            .map((c) => `<option value="${c.id}">${c.cate_name}</option>`)
            .join("")
      );
    });
  }

  function fetchProducts() {
    $.get("api/all-products.php", function (data) {
      console.log(data);
      const products = data.products || [];
      const html = products
        .map(
          (p, index) =>
            `<div class="p-4 border mb-2 flex justify-between items-center">
              <div>${p.name}</div>
              <button key=${index} class="btn btn-sm btn-outline edit" data-id="${p.id}">Edit</button>
              <button key=${index} class="btn btn-sm btn-outline delete" data-id="${p.id}">Delete</button>
               
            </div>`
        )
        .join("");
      $("#productList").html(html);
    });
  }

  fetchCategories();
  fetchProducts();

  $("#images").on("change", function () {
    const files = this.files;
    for (let i = 0; i < files.length; i++) {
      imageFiles.push(files[i]);
    }

    $("#fileList").html(
      `<p>Selected files: ${imageFiles.map((f) => f.name).join(", ")}</p>`
    );
    console.log("existing image from images change", existingImages);
    console.log("imageFiles from image change", imageFiles);
    renderImages();
  });

  function renderImages() {
    $("#imagesList").html("");

    // Render new images
    imageFiles.forEach((file) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const html = `
          <div class="relative">
            <img src="${e.target.result}" class="w-16 h-16 object-cover rounded" />
            <button class="absolute top-0 right-0 bg-red-500 text-white px-1 text-xs rounded remove-btn" data-name="${file.name}">×</button>
          </div>
        `;
        $("#imagesList").append(html);
      };
      reader.readAsDataURL(file);
    });

    // Render existing images
    existingImages.forEach((image) => {
      const html = `
        <div class="relative m-1 existing-image" data-url="${image}">
          <img src="${image}" class="w-16 h-16 object-cover rounded" />
          <button class="absolute top-0 right-0 bg-red-600 text-white rounded text-xs px-1 remove-existing">×</button>
        </div>
      `;
      $("#imagesList").append(html);
    });
  }

  $("#imagesList").on("click", ".remove-btn", function () {
    const name = $(this).data("name");
    imageFiles = imageFiles.filter((file) => file.name !== name);
    renderImages();
  });

  $("#imagesList").on("click", ".remove-existing", function () {
    const url = $(this).parent().data("url");
    existingImages = existingImages.filter((image) => image !== url);
    $(this).parent().remove();
  });

  $("#productList").on("click", ".edit", function () {
    const id = $(this).data("id");
    console.log(id);

    $.get("api/get-product.php", { id: id }, function (response) {
      console.log("API Response:", response);
      const product = response.product;
      console.log("pro", product);

      $("#productId").val(product.id);
      $("#name").val(product.name);
      $("#brand").val(product.brand);
      $("#category").val(product.category);
      $("#price").val(product.price);
      $("#description").val(product.description);
      $("#detail").val(product.detail);
      $("#status").val(product.status);
      $("input[name='action']").val("update");
      $(".btn[type='submit']").text("Update Product");

      // Reset image lists and variables
      imageFiles = [];
      existingImages = [];
      $("#imagesList").html("");

      // Initialize with existing images from the database
      const imageUrls = JSON.parse(product.urls);
      existingImages = imageUrls; // Store the existing images in a variable
      console.log("existing image url from edit", existingImages);
      // Display existing images
      imageUrls.forEach((image) => {
        const imgHtml = `
          <div class="relative m-1 existing-image" data-url="${image}">
            <img src="${image}" class="w-16 h-16 object-cover rounded" />
            <button class="absolute top-0 right-0 bg-red-600 text-white rounded text-xs px-1 remove-existing">×</button>
          </div>`;
        $("#imagesList").append(imgHtml);
      });
    });
  });

  $("#productForm").on("submit", function (e) {
    e.preventDefault();

    const action = $("input[name='action']").val();
    const formData = new FormData(this);
    const cleanedFormData = new FormData();

    // Add form data excluding images[]
    for (let [key, value] of formData.entries()) {
      if (key !== "images[]") {
        cleanedFormData.append(key, value);
      }
    }

    // Append new images
    imageFiles.forEach((file) => {
      cleanedFormData.append("images[]", file);
    });

    // Append existing images as JSON (URLs only)
    cleanedFormData.append("existingImages", JSON.stringify(existingImages));

    $.ajax({
      url: "api/manage-product.php",
      type: "POST",
      data: cleanedFormData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);

        // Reset form and variables after submission
        imageFiles = [];
        existingImages = [];
        document.getElementById("productForm").reset();
        $("input[name='action']").val("create");
        $(".btn[type='submit']").text("Save Product");
        $("#fileList").html("");
        $("#imagesList").html("");
        fetchProducts();
      },
    });
  });

  $("#productList").on("click", ".delete", function () {
    console.log("click deleting");
    var productId = $(this).data("id"); // Get the product ID from the data-id attribute

    // Confirm before deletion
    if (confirm("Are you sure you want to delete this product?")) {
      // Send DELETE request using AJAX
      $.ajax({
        url: "api/manage-product.php", // The URL of the PHP script
        type: "DELETE", // HTTP method DELETE
        contentType: "application/json", // Tell the server we're sending JSON
        data: JSON.stringify({ id: productId }), // Send the product ID as JSON
        success: function (data) {
          var response = JSON.parse(data); // Parse the JSON response
          if (response.success) {
            alert("Product deleted successfully!");
            // Optionally, you can remove the product from the page
            // $("#product-" + productId).remove();
          } else {
            alert(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
          alert("There was an error with the deletion.");
        },
      });
    }
  });
});
