$(document).ready(function () {
  // This will determine whether we are creating or updating

  // Fetch all categories
  let action = "create";
  function fetchSocialmedia() {
    $.get("api/socialmedia.php", function (data) {
      const socialmedia = data.socialmedia || [];
      console.log(socialmedia);

      const html = socialmedia
        .map(
          (s) =>
            `<div class="p-4 border mb-2 flex justify-between items-center">
              <div>${s.platform}</div>
              <div>${s.url}</div>
              <div class="flex flex-row gap-2">
                <button class="btn btn-sm btn-outline edit" data-id="${s.id}" data-name="${s.platform}">Edit</button>
                <button class="btn btn-sm btn-outline delete" data-id="${s.id}">Delete</button>
              </div>
            </div>`
        )
        .join("");

      $("#socialmediaList").html(html);
    });
  }

  fetchSocialmedia();

  // Handle form submit for create/update
  $("#socialmediaForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", action);

    $.ajax({
      url: "api/manage-socialmedia.php",
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      success: function (response) {
        console.log(response);
        $("#submitSocialmedia").text("Save Socialmedia"); // Change button text to 'Update'
        action = "create";
        document.getElementById("socialmediaForm").reset(); // Reset form
        fetchSocialmedia(); // Refresh category list
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("There was an error with the request.");
      },
    });
  });

  // Handle edit button click
  $("#socialmediaList").on("click", ".edit", function () {
    const id = $(this).data("id");
    action = "update";
    $.get("api/get-socialmedia.php", { id: id }, function (response) {
      const socialmedia = response.socialmedia;

      $("#socialmediaId").val(socialmedia.id);
      $("#platform").val(socialmedia.platform);
      $("#url").val(socialmedia.url);

      $("input[name='socialmedia-action']").val("update");
      $("#submitSocialmedia").text("Update Socialmedia"); // Change button text to 'Update'
    });
  });

  // Handle delete button click
  $("#socialmediaList").on("click", ".delete", function () {
    const socialmediaId = $(this).data("id");

    if (confirm("Are you sure you want to delete this socialmedia?")) {
      $.ajax({
        url: "api/manage-socialmedia.php",
        type: "DELETE",
        contentType: "application/json",
        data: JSON.stringify({ id: socialmediaId }),
        success: function (data) {
          const response = JSON.parse(data);
          if (response.success) {
            alert("Social media deleted successfully!");
            fetchSocialmedia(); // Refresh the category list
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
