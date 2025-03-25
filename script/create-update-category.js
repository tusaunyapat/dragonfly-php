$(document).ready(function () {
  let currentCategoryId = null;
  let action = "create"; // This will determine whether we are creating or updating
  function fetchproductCategories() {
    $.get("api/categories.php", function (data) {
      const categories = data.categories || [];
      console.log("from category product");
      $("#category").html(
        `<option value="">N/A</option>` +
          categories
            .map((c) => `<option value="${c.id}">${c.cate_name}</option>`)
            .join("")
      );
    });
  }
  // Fetch all categories
  function fetchCategories() {
    $.get("api/categories.php", function (data) {
      const categories = data.categories || [];
      console.log(categories);

      const html = categories
        .map(
          (c, index) =>
            `

<tr >
  

  <td class="w-[20%] text-center">
    <div class="flex justify-end items-center sm:flex-row ">
      <button class="btn btn-xs btn-ghost edit text-sm lg:text-md text-gray-500"
              data-id="${c.id}" 
              data-name="${c.cate_name}" 
              title="Edit">
        <!-- Pencil icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke-width="1.5" 
             stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z" />
        </svg>
      </button>

      <button class="btn btn-xs btn-ghost text-sm lg:text-md delete"
              data-id="${c.id}" 
              title="Delete">
        <!-- Trash icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke-width="1.5" 
             stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </td>
  <td class="w-full border-b  px-1 text-sm lg:text-md overflow-x-auto">${c.cate_name}</td>
</tr>






`
        )
        .join("");

      $("#categoryList").html(html);
    });
  }

  fetchCategories();

  // Handle form submit for create/update
  $("#categoryForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", action); // Add action (create or update)

    $.ajax({
      url: "api/manage-category.php",
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      success: function (response) {
        console.log(response);
        $("#submitCategory").text("Save Category"); // Change button text to 'Update'
        action = "create";
        document.getElementById("categoryForm").reset(); // Reset form
        fetchCategories(); // Refresh category list
        fetchproductCategories();
        console.log("start");
        console.log("stop");
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("There was an error with the request.");
      },
    });
  });

  // Handle edit button click
  $("#categoryList").on("click", ".edit", function () {
    const id = $(this).data("id");

    $.get("api/get-category.php", { id: id }, function (response) {
      const category = response.category;

      $("#cateId").val(category.id);
      $("#cate_name").val(category.cate_name);
      $("#cate_created_at").val(category.created_at); // Assuming this exists

      action = "update"; // Set action to update
      $("input[name='action']").val("update");
      $("#submitCategory").text("Update Category"); // Change button text to 'Update'
    });
  });

  // Handle delete button click
  $("#categoryList").on("click", ".delete", function () {
    const cateId = $(this).data("id");

    if (confirm("Are you sure you want to delete this category?")) {
      $.ajax({
        url: "api/manage-category.php",
        type: "DELETE",
        contentType: "application/json",
        data: JSON.stringify({ id: cateId }),
        success: function (data) {
          const response = JSON.parse(data);
          if (response.success) {
            alert("Category deleted successfully!");
            fetchCategories(); // Refresh the category list
            fetchproductCategories();
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
