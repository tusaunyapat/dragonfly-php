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
            `<tr>
              <td class="border-b  pr-2 w-[40%] px-1">
                  <div class="flex flex-row ">
                    <button class="btn btn-xs btn-ghost edit text-sm lg:text-md" data-id="${s.id}" data-name="${s.platform}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z" />
                    </svg>
                  </button>
                  <button class="btn btn-xs btn-ghost delete text-sm lg:text-md" data-id="${s.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </td>

              <td class="border-b w-full px-1 text-sm lg:text-md overflow-x-auto">${s.platform}</td>

              <td class="border-b w-[35%] max-w-xs px-1">
                <div class="overflow-x-auto whitespace-nowrap">
                  <a
                    class="text-sm lg:text-md link link-warning inline-block"
                    target="_blank"
                    href="${s.url}"
                  >link</a>
                </div>
              </td>
            </tr>


`
        )
        .join("");

      $("#socialmediaList").html(html);

      const html_footer = socialmedia.map(
        (s, index) =>
          `
          <div class="col-span-1" textxs md:text-sm>
            <a href=${s.url} class="text-sm hover:text-warning">

            ${s.platform}
            </a>
          </div>
        
          `
      );

      $("#socialmedia_footer").html(html_footer);
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
