$(document).ready(function () {
  let currentCategoryId = null;
  let action = "create"; // This will determine whether we are creating or updating

  // Fetch all categories
  function fetchContacts() {
    $.get("api/contact.php", function (data) {
      const contacts = data.contacts || [];
      console.log(contacts);

      const html = contacts
        .map(
          (c) =>
            `<div class="p-4 border mb-2 flex justify-between items-center">
              <div>${c.name}</div>
              <div>${c.phone}</div>
              <div>${c.other}</div>
              <div class="flex flex-row gap-2">
                <button class="btn btn-sm btn-outline edit" data-id="${c.id}" data-name="${c.name}">Edit</button>
                <button class="btn btn-sm btn-outline delete" data-id="${c.id}">Delete</button>
              </div>
            </div>`
        )
        .join("");

      $("#contactList").html(html);
    });
  }

  fetchContacts();

  // Handle form submit for create/update
  $("#contactForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", action); // Add action (create or update)

    $.ajax({
      url: "api/manage-contact.php",
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      success: function (response) {
        console.log(response);
        $("#submitContact").text("Save Contact");
        document.getElementById("contactForm").reset(); // Reset form
        fetchContacts(); // Refresh category list
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("There was an error with the request.");
      },
    });
  });

  // Handle edit button click
  $("#contactList").on("click", ".edit", function () {
    const id = $(this).data("id");

    $.get("api/get-contact.php", { id: id }, function (response) {
      const contact = response.contact;

      $("#contactId").val(contact.id);
      $("#name").val(contact.name);
      $("#phone").val(contact.phone); // Assuming this exists
      $("#other").val(contact.other); // Assuming this exists

      action = "update"; // Set action to update
      $("input[name='contact-action']").val("update");
      $("#submitContact").text("Update Contact"); // Change button text to 'Update'
    });
  });

  // Handle delete button click
  $("#contactList").on("click", ".delete", function () {
    const contactId = $(this).data("id");

    if (confirm("Are you sure you want to delete this contact?")) {
      $.ajax({
        url: "api/manage-contact.php",
        type: "DELETE",
        contentType: "application/json",
        data: JSON.stringify({ id: contactId }),
        success: function (data) {
          const response = JSON.parse(data);
          $("#submitContact").text("Save Contact"); // Change button text to 'Update'

          if (response.success) {
            alert("Contact deleted successfully!");
            fetchContacts(); // Refresh the category list
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
