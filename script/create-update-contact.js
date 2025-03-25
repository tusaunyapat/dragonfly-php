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
            ` <tr>
                <th class="border-b  w-[5%] px-1">
                  <div class="flex flex-row ">
                    <button class="btn btn-xs btn-ghost edit text-sm lg:text-md" data-id="${c.id}" data-name="${c.name}">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                      viewBox="0 0 24 24" stroke-width="1.5" 
                      stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z" />
                      </svg>
                    </button>
                    <button class="btn btn-xs btn-ghost delete text-sm lg:text-md" data-id="${c.id}"> 
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                      viewBox="0 0 24 24" stroke-width="1.5" 
                      stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </th>
                <th class="border-b w-[30%] px-1 text-sm lg:text-md">${c.name}</td>
                <td class="border-b w-[20%] px-1 text-sm lg:text-md">${c.phone}</td>
                <td class="border-b w-[45%] px-1 overflow-x-auto text-sm lg:text-md ">${c.other}</td>
              </tr>

`
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
