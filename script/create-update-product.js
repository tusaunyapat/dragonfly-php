$(document).ready(function () {
  let imageFiles = [];
  let existingImages = []; // To store the existing image URLs when editing a product

  let action = "create";
  function fetchproductCategories() {
    $.get("api/categories.php", function (data) {
      const categories = data.categories || [];
      $("#category").html(
        categories
          .map(
            (c) =>
              `
              <div class="flex flex-row gap-1">
              
              <input name="category[]" type="checkbox" class="checkbox checkbox-sm checkbox-warning" value="${
                c.id
              }"></input>
              <label class="text-sm">${c.cate_name || "N/A"}</label></div>`
          )
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
            `
            <tr>
  <!-- Action Buttons -->
  <td class="border-b w-[30%] sm:w-[20%] px-1">
    <div class="flex flex-row">
      <button key=${index} class="btn btn-xs btn-ghost edit text-sm lg:text-md" data-id="${
              p.id
            }">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke-width="1.5" 
             stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z" />
        </svg>
      </button>
      <button key=${index} class="btn btn-xs btn-ghost text-sm lg:text-md delete" data-id="${
              p.id
            }">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke-width="1.5" 
             stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </td>

  <!-- Product Name (scrollable if long) -->
  <th class="border-b w-full px-1 text-sm lg:text-md">
    <div class="overflow-x-auto whitespace-nowrap">
      <span class="inline-block min-w-full">${p.name}</span>
    </div>
  </th>

  <!-- Status -->
<td class="border-b px-1 overflow-x-auto ">
  <p class="badge badge-outline ${
    p.status === "DRAFT"
      ? "badge-neutral"
      : p.status === "ACTIVE"
      ? "badge-success"
      : "badge-error"
  }">
  ${p.status}
</p>

</td>


  <!-- Price -->
  <td class="border-b w-[10%] px-1 text-sm lg:text-md">${p.price}</td>
</tr>

              `
        )
        .join("");
      $("#productList").html(html);
    });
  }

  fetchproductCategories();
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
    $("#category input[type='checkbox']").prop("checked", false);
    action = "update";
    $.get("api/get-product.php", { id: id }, function (response) {
      console.log("API Response:", response);

      const product = response.product;
      console.log("pro", product);

      $("#productId").val(product.id);
      $("#product-name").val(product.name);
      $("#brand").val(product.brand);
      // Assuming the checkboxes have a value corresponding to category id

      product.category.forEach((category) => {
        $(`#category input[type="checkbox"][value="${category.id}"]`).prop(
          "checked",
          true
        );
      });

      $("#price").val(product.price);
      $("#description").val(product.description);
      $("#detail").val(product.detail);
      $("#status").val(product.status);
      $("input[name='product-action']").val("update");
      $("#submitProduct").text("Update Product");

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

    const formData = new FormData(this);
    const cleanedFormData = new FormData();

    // Add form data excluding images[]
    for (let [key, value] of formData.entries()) {
      if (key !== "images[]" && key !== "category") {
        cleanedFormData.append(key, value);
      }
    }

    const checkedCategories = [];

    // Get all checked checkboxes with name "category[]"
    $('input[name="category[]"]:checked').each(function () {
      checkedCategories.push($(this).val()); // Push the value of the checked checkbox (category ID)
    });

    // Append new images
    imageFiles.forEach((file) => {
      cleanedFormData.append("images[]", file);
    });

    // Append existing images as JSON (URLs only)
    cleanedFormData.append("existingImages", JSON.stringify(existingImages));
    cleanedFormData.append("action", action);
    cleanedFormData.append("category", JSON.stringify(checkedCategories));

    $.ajax({
      url: "api/manage-product.php",
      type: "POST",
      data: cleanedFormData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        action = "create";
        // Reset form and variables after submission
        imageFiles = [];
        existingImages = [];
        fetchProducts();
        fetchproductCategories();
        document.getElementById("productForm").reset();
        $("input[name='action']").val("create");
        $("#submitProduct").text("Save Product");
        $("#fileList").html("");
        $("#imagesList").html("");
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
            fetchProducts();
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
