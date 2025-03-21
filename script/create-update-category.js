$(document).ready(function () {
  let currentCategoryId = null;
  let action = "create"; // This will determine whether we are creating or updating

  // Fetch all categories
  function fetchCategories() {
    $.get("api/categories.php", function (data) {
      const categories = data.categories || [];
      console.log(categories);

      const html = categories
        .map(
          (c) =>
            `<div class="border border-accent rounded-lg flex justify-between items-center join join-horizontal">
  <div class="join-item px-2 rounded-l-md "><p>${c.cate_name}</p></div>
  <div class="flex flex-row join-item join">
    <button class="join-item btn btn-sm btn-outline border-none  edit" data-id="${c.id}" data-name="${c.cate_name}">Edit</button>
    <button class="join-item btn btn-sm btn-outline border-none delete" data-id="${c.id}">Delete</button>
  </div>
</div>
</div>
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

        document.getElementById("categoryForm").reset(); // Reset form
        fetchCategories(); // Refresh category list
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
