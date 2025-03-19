$(document).ready(function () {
  let imageFiles = []; // Array to hold the selected files

  // Fetch categories
  function fetchCategories() {
    $.get("api/categories.php", function (data) {
      console.log(data);
      let categories = data.categories;

      // Populate category dropdown
      $("#category").html(
        `<option value="">N/A</option>` +
          categories
            .map((c) => `<option value="${c.id}">${c.cate_name}</option>`)
            .join("")
      );
    });
  }

  // Fetch products
  function fetchProducts() {
    $.get("api/products.php", function (data) {
      let products = data.products;
      let html = products
        .map(
          (p) =>
            `<div class="p-4 border mb-2">${p.name} - <button class="btn btn-sm btn-outline edit" data-id="${p.id}">Edit</button></div>`
        )
        .join("");
      $("#productList").html(html);
    });
  }

  // Initial fetch
  fetchCategories();
  fetchProducts();

  // Handle image input change event
  $("#images").on("change", function () {
    let files = this.files;

    // Add new files to the imageFiles array
    Array.from(files).forEach((file) => {
      imageFiles.push(file);
    });

    console.log("after insert images", imageFiles);

    // Optionally, display the file names or preview images
    let fileNames = imageFiles.map((file) => file.name).join(", ");
    $("#fileList").html(`<p>Selected files: ${fileNames}</p>`);

    // Create HTML for images dynamically (no need to replace the whole list)
    Array.from(files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const imgHtml = `
          <div class="image-container" id="image-${index}">
            <img src="${e.target.result}" class="w-16 h-16 object-cover" />
            <button class="remove-btn" data-name="${file.name}">Remove</button>
          </div>`;
        $("#imagesList").append(imgHtml); // Add image preview
      };
      reader.readAsDataURL(file); // Read image as data URL
    });
  });

  // Event listener for remove button
  $("#imagesList").on("click", ".remove-btn", function () {
    const name = $(this).data("name"); // Get the name of the image to remove

    // Remove the image file from the imageFiles array by name
    imageFiles = imageFiles.filter((file) => file.name !== name);

    console.log("after click remove", imageFiles);

    // Re-render the images list after removal without replacing the entire content
    $("#imagesList").html("");
    imageFiles.forEach((file, idx) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const imgHtml = `
          <div class="image-container" id="image-${idx}">
            <img src="${e.target.result}" class="w-16 h-16 object-cover" />
            <button class="remove-btn" data-name="${file.name}">Remove</button>
          </div>`;
        $("#imagesList").append(imgHtml); // Re-append remaining files
      };
      reader.readAsDataURL(file);
    });
  });

  // Handle product form submission
  $("#productForm").on("submit", function (e) {
    e.preventDefault();

    // Prevent multiple submissions
    if ($(this).data("submitting")) return;
    $(this).data("submitting", true);

    // Reset FormData for each submission
    let formData = new FormData(this); // Recreate FormData object

    // Create a temporary FormData object to append non-image data
    let cleanedFormData = new FormData();

    // Append everything except images[] to the cleanedFormData
    for (let [key, value] of formData.entries()) {
      if (key !== "images[]") {
        cleanedFormData.append(key, value);
      }
    }

    // Now, append the image files manually (if needed)
    imageFiles.forEach((img) => {
      cleanedFormData.append("images[]", img);
    });

    // Log the cleanedFormData
    for (let pair of cleanedFormData.entries()) {
      console.log(pair[0] + ": " + pair[1]);
    }
    // Make the AJAX request to submit the form
    $.ajax({
      url: "api/manage-product.php",
      type: "POST",
      data: cleanedFormData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        // Reset form and clear image array
        imageFiles = [];
        document.getElementById("productForm").reset();

        $("#fileList").html(""); // Clear file list display
        $("#imagesList").html(""); // Clear image previews
        // Fetch updated product list
        fetchProducts();
      },
    });
  });
});
